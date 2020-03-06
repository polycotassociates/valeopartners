<?php

namespace Drupal\entity_activity_mass_subscribe\Form;

use Drupal\Core\Database\Database;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\Role;
use Drupal\user\RoleInterface;
use Drupal\user\UserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * MassSubscribe form.
 */
class MassSubscribeForm extends FormBase implements ContainerInjectionInterface {

  /**
   * The entity repository service.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  protected $entityRepository;

  /**
   * Drupal\Core\Routing\RouteMatchInterface definition.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The subscription storage.
   *
   * @var \Drupal\entity_activity\SubscriptionStorageInterface
   */
  protected $storageSubscription;

  /**
   * The user storage.
   *
   * @var \Drupal\user\UserStorageInterface
   */
  protected $storageUser;

  /**
   * The default limit used to display users in the table select.
   *
   * @var integer
   */
  protected $limit = 50;

  /**
   * The value corresponding to an unlimited query.
   *
   * @var int
   */
  protected $unlimited = -1;

  /**
   * ListSubscribersController constructor.
   *
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *   The route match service.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(EntityRepositoryInterface $entity_repository, EntityTypeManagerInterface $entity_type_manager, RouteMatchInterface $route_match) {
    $this->entityRepository = $entity_repository;
    $this->entityTypeManager = $entity_type_manager;
    $this->routeMatch = $route_match;
    $this->storageSubscription = $this->entityTypeManager->getStorage('entity_activity_subscription');
    $this->storageUser = $this->entityTypeManager->getStorage('user');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.repository'),
      $container->get('entity_type.manager'),
      $container->get('current_route_match')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'entity_activity_mass_subscribe';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, AccountInterface $account = NULL, EntityInterface $entity = NULL) {
    if (!$account) {
      $account = $this->currentUser();
    }

    if (!$entity instanceof ContentEntityInterface) {
      $entity = $this->getCurrentEntity();
    }
    if (!$entity instanceof ContentEntityInterface) {
      return $form['#markup'] = $this->t('No entity found for mass subscribe feature');
    }

    $form['#theme'] = 'system_config_form';

    $form['entity'] = [
      '#type' => 'value',
      '#value' => $entity,
    ];

    $form['account'] = [
      '#type' => 'value',
      '#value' => $account,
    ];

    $methods = $this->getMethods($account, $entity);
    $form['method'] = [
      '#type' => 'select',
      '#title' => $this->t('Method'),
      '#description' => $this->t('Select a method to mass subscribe users to the @type <em>@label</em>.', ['@type' => $this->getEntityTypeLabel($entity), '@label' => $entity->label()]),
      '#options' => $methods,
      '#required' => TRUE,
      '#default_value' => '',
      '#ajax' => [
        'event' => 'change',
        'method' => 'replace',
        'wrapper' => 'subscribe-wrapper',
        'callback' => [$this, 'ajaxReplaceSubscribeCallback'],
      ],
    ];

    if (count($methods) <= 1) {
      $form['message'] = [
        '#type' => 'item',
        '#markup' => $this->t('Your current permissions do not allow you to access the mass subscription. Please contact an administrator.'),
        '#wrapper_attributes' => ['class' => ['messages', 'messages--warning']],
      ];
    }

    $form['subscribe'] = [
      '#type' => 'container',
      '#tree' => TRUE,
      '#prefix' => '<div id="subscribe-wrapper">',
      '#suffix' => '</div>',
    ];

    $method = $this->getElementPropertyValue('method', $form_state);
    if ($method) {
      switch ($method) {
        case 'role':
          $form['subscribe']['role'] = $this->getElementRole($form, $form_state);
          break;

        case 'user':
          $form['subscribe']['user'] = $this->getElementUser($form, $form_state);
          break;

        case 'list':
          $form['subscribe']['list'] = $this->getElementList($form, $form_state, $entity);
          $form['subscribe']['list']['#prefix'] = '<div id="user-list">';
          $form['subscribe']['list']['#suffix'] = '</div>';
          break;
      }
    }

    $form['unsubscribe'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Unsubscribe'),
      '#description' => $this->t('Check this option to <b>unsubcribe</b> users instead of subscribe them'),
      '#default_value' => 0,
      '#access' => (bool) $account->hasPermission('mass unsubscribe users'),
      '#states' => [
        'invisible' => [
          ':input[name="method"]' => ['value' => ''],
        ],
      ],
    ];

    $form['warning'] = [
      '#type' => 'item',
      '#markup' => $this->t('You have enabled the <b>Unsubscribe</b> mode. You are going to <b>unsubscribe</b> users selected instead of <em>subscribe</em> them.'),
      '#wrapper_attributes' => ['class' => ['messages', 'messages--warning']],
      '#access' => (bool) $account->hasPermission('mass unsubscribe users'),
      '#states' => [
        'visible' => [
          ':input[name="unsubscribe"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Mass subscribe'),
      '#button_type' => 'primary',
      '#access' => (bool) (count($methods) > 1),
    ];

    return $form;
  }

  /**
   * Ajax replace callback.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The form to return.
   */
  public function ajaxReplaceSubscribeCallback(array $form, FormStateInterface $form_state) {
    return $form['subscribe'];
  }

  /**
   * Ajax replace callback.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The form to return.
   */
  public function ajaxFilterCallback(array &$form, FormStateInterface &$form_state) {
    return $form['subscribe'];
  }

  /**
   * Get element property value.
   *
   * @param string|array $property
   *   The property to check.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   * @param mixed $default
   *   The default value returned if property not found.
   *
   * @return array|mixed|null
   *   The value of the property found or the default value provided.
   */
  protected function getElementPropertyValue($property, FormStateInterface $form_state, $default = '') {
    return $form_state->hasValue($property)
      ? $form_state->getValue($property)
      : $default;
  }

  /**
   * Get the form element role.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The form element.
   */
  protected function getElementRole($form, FormStateInterface $form_state) {
    $element = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Role'),
      '#description' => $this->t('Select the role(s) for which mass subscribe users.'),
      '#options' => $this->getRoles(),
      '#default_value' => $this->getElementPropertyValue(['subscribe', 'role'], $form_state, []),
      '#required' => TRUE,
    ];
    return $element;
  }

  /**
   * Get the form element user.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   *
   * @return array
   *   The form element.
   */
  protected function getElementUser($form, FormStateInterface $form_state) {
    $element = [
      '#type' => 'entity_autocomplete',
      '#size' => 180,
      '#title' => $this->t('User'),
      '#description' => $this->t('Select the user(s) you want mass subscribe. Use a comma-separated list (,) to select multiple users. (For example: User1, User2, User3'),
      '#target_type' => 'user',
      '#tags' => TRUE,
      '#validate_reference' => TRUE,
      '#autocreate' => FALSE,
      '#required' => TRUE,
      '#selection_settings' => [
        'include_anonymous' => FALSE,
      ],
    ];
    // @TODO provide options to filter per role.
    // $element['#selection_settings']['filter'] = [
    //   'role' => [],
    // ];
    return $element;
  }

  /**
   * Get the form element list.
   *
   * @param array $form
   *   The form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The current entity.
   *
   * @return array
   *   The element form.
   */
  protected function getElementList(&$form, FormStateInterface &$form_state, ContentEntityInterface $entity) {
    $triggering_element = $form_state->getTriggeringElement();
    if ($triggering_element['#name'] == 'reset') {
      $form_state->setValue(['subscribe', 'list', 'filters'], []);
      $user_input = $form_state->getUserInput();
      $user_input['subscribe']['list']['filters'] = [];
      $form_state->setUserInput($user_input);
    }

    $limit = (int) $this->getElementPropertyValue(['subscribe', 'list', 'filters', 'limit'], $form_state, $this->limit);
    // @TODO no offset form currently on the form element.
    $offset = $this->getElementPropertyValue(['subscribe', 'list', 'filters', 'offset'], $form_state, 0);
    $is_filtered = FALSE;

    // @TODO filter user given roles configured on the futur steeings form.
    $total_query = $this->storageUser->getQuery()
      ->condition('status', 1);

    $query = $this->storageUser->getQuery();
    $query->condition('status', 1);
    $query->sort('name', 'ASC');
    if ($limit) {
      if ($limit !== $this->limit) {
        $is_filtered = TRUE;
      }
      if ($limit !== $this->unlimited) {
        $query->range($offset, $limit);
      }
    }

    $search = $this->getElementPropertyValue(['subscribe', 'list', 'filters', 'search'], $form_state, '');
    if (!empty($search)) {
      $is_filtered = TRUE;
      $search = Database::getConnection()->escapeLike($search);
      $condition_or = $query->orConditionGroup();
      $condition_or->condition('name', '%' . ($search) . '%', 'like');
      $condition_or->condition('mail', '%' . ($search) . '%', 'like');
      $query->condition($condition_or);
      $total_query->condition($condition_or);
    }

    $role = $this->getElementPropertyValue(['subscribe', 'list', 'filters', 'role'], $form_state, '');
    if (!empty($role)) {
      $is_filtered = TRUE;
      $role = Database::getConnection()->escapeLike($role);
      $condition_or = $query->orConditionGroup();
      $condition_or->condition('roles', $role, 'IN');
      $query->condition($condition_or);
      $total_query->condition($condition_or);
    }

    $clone_query = clone $query;
    $count = $clone_query->count()->execute();
    $total = $total_query->count()->execute();

    $results = $query->execute();

    /** @var \Drupal\user\UserInterface[] $users */
    $users = $this->storageUser->loadMultiple($results);

    $element['filters'] = [
      '#type' => 'details',
      '#title' => $this->t('Filter'),
      '#open' => $is_filtered,
      '#attributes' => [
        'class' => [
          'inline-children',
        ],
      ],
    ];
    $element['filters']['search'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Search'),
      '#size' => 20,
      '#default_value' => $this->getElementPropertyValue(['subscribe', 'list', 'filters', 'search'], $form_state, ''),
      '#attributes' => [
        'class' => [
          'filter-element',
        ],
      ],
    ];

    $element['filters']['role'] = [
      '#type' => 'select',
      '#title' => $this->t('Role'),
      '#options' => ['' => $this->t('All')] + $this->getRoles(TRUE),
      '#default_value' => $this->getElementPropertyValue(['subscribe', 'list', 'filters', 'search'], $form_state, ''),
      '#attributes' => [
        'class' => [
          'filter-element',
        ],
      ],
    ];

    $element['filters']['limit'] = [
      '#type' => 'select',
      '#title' => $this->t('Limit'),
      '#options' => $this->getRanges(),
      '#default_value' => $this->getElementPropertyValue(['subscribe', 'list', 'filters', 'limit'], $form_state, '50'),
      '#attributes' => [
        'class' => [
          'filter-element',
        ],
      ],
    ];

    $element['filters']['actions'] = [
      '#type' => 'actions',
    ];
    $element['filters']['actions']['filter'] = [
      '#type' => 'button',
      '#value' => t('Filter'),
      '#name' => 'filter',
      '#ajax' => [
        'callback' => [$this, 'ajaxFilterCallback'],
        'wrapper' => 'subscribe-wrapper',
        'method' => 'replace',
      ],
    ];
    $element['filters']['actions']['reset'] = [
      '#type' => 'button',
      '#value' => t('Reset'),
      '#name' => 'reset',
      '#ajax' => [
        'callback' => [$this, 'ajaxFilterCallback'],
        'wrapper' => 'subscribe-wrapper',
        'method' => 'replace',
      ],
    ];

    $element['total'] = [
      '#type' => 'markup',
      '#markup' => $this->stringTranslation->formatPlural($count, '1 user displayed (for a total of @total users).', '@count users displayed (for a total of @total users).', ['@count' => $count, '@total' => $total])->render(),
    ];

    $element['table'] = [
      '#type' => 'tableselect',
      '#title' => $this->t('Users'),
      '#header' => $this->getHeaders(),
      '#options' => $this->getOptions($users, $entity),
      '#default_value' => [],
      '#empty' => t('No users found'),
    ];

    $element['table']['#attached']['library'][] = 'core/drupal.tableselect';
    $element['table']['#attached']['library'][] = 'entity_activity_mass_subscribe/mass_subscribe';
    return $element;
  }

  /**
   * Get the table select headers.
   *
   * @return array
   *   An array of headers for the table select form.
   */
  protected function getHeaders() {
    $headers = [
      'name' => $this->t('Username'),
      'role' => $this->t('Role'),
      'subscribed' => $this->t('Subscribed'),
    ];
    return $headers;
  }

  /**
   * Get the table select options.
   *
   * @param \Drupal\user\UserInterface[] $users
   *   An array of users object.
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The current entity against check if a subscription exists.
   *
   * @return array
   *   An array of options for the table select form.
   */
  protected function getOptions($users, ContentEntityInterface $entity) {
    $options = [];
    /** @var \Drupal\user\UserInterface $user */
    foreach ($users as $id => $user) {
      $options[$id]['name'] = $user->getDisplayName();
      $options[$id]['role'] = implode(', ', $this->getUserRoles($user));
      $options[$id]['subscribed'] = !empty($this->storageSubscription->loadMultipleByEntityAndOwner($entity, $user, $entity->language()->getId())) ? $this->t('Yes') : '';
    }
    return $options;
  }

  /**
   * Get the user roles.
   *
   * @param \Drupal\user\UserInterface $user
   *   The given user entity.
   *
   * @return array
   *   An array of roles of the user.
   */
  protected function getUserRoles(UserInterface $user) {
    $roles = user_role_names(TRUE);
    unset($roles[RoleInterface::AUTHENTICATED_ID]);
    $users_roles = [];
    foreach ($user->getRoles() as $role) {
      if (isset($roles[$role])) {
        $users_roles[] = $roles[$role];
      }
    }
    asort($users_roles);
    return $users_roles;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->cleanValues()->getValues();
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $values['account'];
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = $values['entity'];
    // The mass subscribe global permissions can be removed to a user. So we
    // check again if the current user has yet one the the permission.
    if (!$this->hasGlobalPermission($account, $entity)) {
      $form_state->setError($form['method'], $this->t('Access denied'));
    }

    $unsubscribe = !empty($values['unsubscribe']);
    if ($unsubscribe && !$account->hasPermission('mass unsubscribe users')) {
      $form_state->setError($form['unsubscribe'], $this->t('Access denied'));
    }

    $method = !empty($values['method']) ? $values['method'] : '';
    if (empty($method)) {
      $form_state->setError($form['method'], $this->t('You must select a method.'));
    }
    if ($method && empty($values['subscribe'][$method])) {
      $form_state->setError($form['subscribe'], $this->t('An error occurs with your selection. Please retry.'));
    }
    if ($method) {
      $permission = 'mass subscribe per ' . $method;
      if (!$account->hasPermission($permission)) {
        $form_state->setError($form['method'], $this->t('Access denied'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->cleanValues()->getValues();
    $method = !empty($values['method']) ? $values['method'] : '';
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = $values['entity'];
    /** @var \Drupal\Core\Session\AccountInterface $account */
    $account = $values['account'];
    $unsubscribe = !empty($values['unsubscribe']);
    // A last check about the unsubscribe feature. Certainly a bit too much.
    if (!$account->hasPermission('mass unsubscribe users')) {
      $unsubscribe = FALSE;
    }

    $subscribe = !empty($values['subscribe'][$method]) ? $values['subscribe'][$method] : [];
    if (empty($subscribe)) {
      $this->messenger()->addStatus($this->t('No results found to launch a mass subscribe process.'));
      return;
    }

    $user_ids = [];
    switch ($method) {
      case 'role':
        $roles = array_filter($subscribe);
        $query = $this->storageUser->getQuery()
          ->condition('status', 1)
          ->condition('roles', $roles, 'IN');
        $user_ids = $query->execute();
        break;

      case 'user':
        foreach ($subscribe as $value) {
          if (empty($value['target_id'])) {
            continue;
          }
          $id = (string) $value['target_id'];
          $user_ids[$id] = $id;
        }
        break;

      case 'list':
        if (!empty($subscribe['table'])) {
          $user_ids = array_filter($subscribe['table']);
        }
        break;
    }

    if (!empty($user_ids)) {
      $batch = [
        'title' => $this->t('Subscribing users on @type @label', [
          '@type' => $this->getEntityTypeLabel($entity),
          '@label' => $entity->label(),
        ]),
        'operations' => [
          [
            '\Drupal\entity_activity_mass_subscribe\MassSubscribeBatch::subscribe',
            [$user_ids, $entity, $account, $unsubscribe],
          ],
        ],
        'finished' => '\Drupal\entity_activity_mass_subscribe\MassSubscribeBatch::finished',
      ];
      batch_set($batch);
    }
    else {
      $this->messenger()->addWarning($this->t('No results found to launch a mass subscribe process.'));
      return;
    }

  }

  /**
   * The _title_callback for the mass subscribe form.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The current entity.
   *
   * @return string
   *   The page title.
   */
  public function title(EntityInterface $entity = NULL) {
    if (!$entity instanceof ContentEntityInterface) {
      $entity = $this->getCurrentEntity();
    }
    if (!$entity instanceof ContentEntityInterface) {
      return $this->t('Mass subscribe unavailable');
    }
    return $this->t('Mass subscribe users on @label', ['@label' => $entity->label()]);
  }

  /**
   * Get the entity type label given an entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity object.
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup|string
   *   The entity type label.
   */
  protected function getEntityTypeLabel(ContentEntityInterface $entity) {
    return $entity->getEntityType()->getLabel();
  }

  /**
   * Get the roles.
   *
   * @param bool $exclude_authenticated
   *   Exclude the authenticated role.
   *
   * @return array
   *   An array of roles available on the site.
   */
  protected function getRoles($exclude_authenticated = FALSE) {
    $roles = [];
    /** @var \Drupal\user\RoleInterface $role */
    foreach (Role::loadMultiple() as $role) {
      if ($role->id() === RoleInterface::ANONYMOUS_ID) {
        continue;
      }
      if ($exclude_authenticated && $role->id() === RoleInterface::AUTHENTICATED_ID) {
        continue;
      }
      $roles[$role->id()] = $role->label();
    }
    return $roles;
  }

  /**
   * Get available ranges.
   *
   * @return array
   *   An array of range value.
   */
  protected function getRanges() {
    $ranges = [];
    $ranges['50'] = $this->t('50 results');
    $ranges['100'] = $this->t('100 results');
    $ranges['150'] = $this->t('150 results');
    $ranges['200'] = $this->t('200 results');
    $ranges['300'] = $this->t('300 results');
    $ranges['400'] = $this->t('400 results');
    $ranges['500'] = $this->t('500 results');
    $ranges['-1'] = $this->t('All results');
    return $ranges;
  }

  /**
   * Get methods available given a user.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The current user performing the action.
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The related entity to the mass subscribe action..
   *
   * @return array
   *   An array of methods.
   */
  protected function getMethods(AccountInterface $account, ContentEntityInterface $entity) {
    $methods = [
      '' => $this->t('Select a method'),
    ];
    if (!$this->hasGlobalPermission($account, $entity)) {
      return $methods;
    }
    if ($account->hasPermission('mass subscribe per role')) {
      $methods['role'] = $this->t('Per role');
    }
    if ($account->hasPermission('mass subscribe per user')) {
      $methods['user'] = $this->t('Per user');
    }
    if ($account->hasPermission('mass subscribe per list')) {
      $methods['list'] = $this->t('Per list');
    }
    return $methods;
  }

  /**
   * Check global permissions.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The account object.
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity object.
   *
   * @return bool
   *   TRUE if account has the permission on the entity. Otherwise FALSE;
   */
  protected function hasGlobalPermission(AccountInterface $account, ContentEntityInterface $entity) {
    $has_permission = FALSE;
    if ($account->hasPermission('mass subscribe users')) {
      $has_permission = TRUE;
    }
    elseif ($account->hasPermission('mass subscribe users on editable entities')) {
      if ($entity->access('update', $account)) {
        $has_permission = TRUE;
      }
    }
    return $has_permission;
  }

  /**
   * Get the current entity from the route.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   *   The current entity found in the route or NULL.
   */
  protected function getCurrentEntity() {
    $entity = NULL;
    $keys = $this->routeMatch->getParameters()->keys();
    $entity_type_id = isset($keys[0]) ? $keys[0] : '';
    if (empty($entity_type_id)) {
      return $entity;
    }
    $entity = $this->routeMatch->getParameter($entity_type_id);
    return $entity;
  }

}
