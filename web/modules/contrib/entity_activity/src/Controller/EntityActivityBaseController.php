<?php

namespace Drupal\entity_activity\Controller;

use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\entity_activity\EntityActivityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Component\Datetime\TimeInterface;

/**
 * Class EntityActivityBaseController.
 */
abstract class EntityActivityBaseController extends ControllerBase implements EntityActivityBaseControllerInterface {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Drupal\Core\Entity\EntityRepositoryInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityRepositoryInterface
   */
  protected $entityRepository;

  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Drupal\entity_activity\EntityActivityManagerInterface.
   *
   * @var \Drupal\entity_activity\EntityActivityManagerInterface
   */
  protected $entityActivityManager;

  /**
   * Symfony\Component\HttpFoundation\RequestStack definition.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Drupal\Core\Render\Renderer definition.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * Drupal\Component\Datetime\TimeInterface definition.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $time;

  /**
   * Drupal\Core\Language\LanguageManagerInterface definition
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * EntityActivityBaseController constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Entity\EntityRepositoryInterface $entity_repository
   *   The entity repository service.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   * @param \Drupal\entity_activity\EntityActivityManagerInterface $entity_activity_manager
   *   The entity activity manager.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   * @param \Drupal\Component\Datetime\TimeInterface $time
   *   The time service.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, EntityRepositoryInterface $entity_repository, AccountProxyInterface $current_user, EntityActivityManagerInterface $entity_activity_manager, RequestStack $request_stack, RendererInterface $renderer, TimeInterface $time, LanguageManagerInterface $language_manager) {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityRepository = $entity_repository;
    $this->currentUser = $current_user;
    $this->entityActivityManager = $entity_activity_manager;
    $this->requestStack = $request_stack;
    $this->renderer = $renderer;
    $this->time = $time;
    $this->languageManager = $language_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('entity.repository'),
      $container->get('current_user'),
      $container->get('entity_activity.manager'),
      $container->get('request_stack'),
      $container->get('renderer'),
      $container->get('datetime.time'),
      $container->get('language_manager')
    );
  }

  /**
   * Get a not valid Json Response with a 401 code.
   *
   * @param array $data
   *   The data pass to the endpoint.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The default Json response.
   */
  protected function notValidRequest(array $data) {
    return $this->getResponse(400, 'Data provided in the post request are not valid.', $data);
  }

  /**
   * Get a default Json Response with a 500 code.
   *
   * @param array $data
   *   The data pass to the endpoint.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The default Json response.
   */
  protected function defaultResponse(array $data) {
    return $this->getResponse(500, 'An issue has occurred. Please contact an administrator.', $data);
  }

  /**
   * Get an access denied Response with a 403 code.
   *
   * @param array $data
   *   The data pass to the endpoint.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   The access denied Json response.
   */
  protected function accessDeniedResponse(array $data) {
    return $this->getResponse(403, 'Access denied.', $data);
  }

  /**
   * Check if some properties in an array are valid.
   *
   * @param array $properties
   *   The properties to check.
   * @param array $data
   *   The array with the property as a key.
   *
   * @return bool
   *   Return TRUE if the values for the keys $properties are valid.
   */
  protected function dataIsValid(array $properties, array $data) {
    $result = TRUE;
    foreach ($properties as $property) {
      if (!$this->propertyIsValid($property, $data)) {
        $result = FALSE;
        break;
      }
    }
    return $result;
  }

  /**
   * Check if a property in an array is valid.
   *
   * @param string $property
   *   The property to check.
   * @param array $data
   *   The array with the property as a key.
   *
   * @return bool
   *   Return TRUE if the value for the key $property is valid.
   */
  protected function propertyIsValid($property, array $data) {
    $result = FALSE;
    if (empty($data[$property])) {
      return $result;
    }

    switch ($property) {
      case 'entity_type':
        $supported_entity_types = $this->entityActivityManager->getSupportedContentEntityTypes();
        try {
          $storage = $this->entityTypeManager->getStorage($data[$property]);
        }
        catch (PluginNotFoundException $exception) {
          $storage = NULL;
        }

        if (in_array($data[$property], $supported_entity_types) && $storage instanceof EntityStorageInterface) {
          $result = TRUE;
        }
        break;

      case 'entity_id':
        if (is_numeric($data[$property])) {
          $result = TRUE;
        }
        break;

      case 'langcode':
        $languages = $this->languageManager->getLanguages(LanguageInterface::STATE_ALL);
        if (is_string($data[$property]) && isset($languages[$data[$property]])) {
          $result = TRUE;
        }
        break;

      default:
        if (is_string($data[$property])) {
          $result = TRUE;
        }
        break;
    }

    return $result;
  }

  /**
   * Fetch POST data from the request.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The request.
   *
   * @return array
   *   An array of data expected.
   */
  protected function getPostData(Request $request) {
    $content = $request->getContent();
    $data = json_decode($content, TRUE);
    return $data;
  }

  /**
   * Fetch the entity from an entity type id and an entity id.
   *
   * @param string $entity_type
   *   The entity type id.
   * @param int $entity_id
   *   The entity id.
   *
   * @return \Drupal\Core\Entity\ContentEntityInterface|null
   *   The entity or NULL.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function getEntity($entity_type, $entity_id) {
    /** @var \Drupal\Core\Entity\ContentEntityInterface $entity */
    $entity = $this->entityTypeManager->getStorage($entity_type)->load($entity_id);
    return $entity;
  }

  /**
   * Check if an account is the owner of an entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity to check.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The account.
   *
   * @return bool
   *   Return TRUE if the account is the entity's owner.
   */
  protected function isOwner(ContentEntityInterface $entity, AccountProxyInterface $account = NULL) {
    $result = FALSE;
    if (!$account) {
      $account = $this->currentUser;
    }
    if (method_exists($entity, 'getOwner')) {
      $result = $entity->getOwner()->id() == $account->id();
    }
    return (bool) $result;
  }

  /**
   * Check if an account has the admin permission on an entity.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The entity to check.
   * @param \Drupal\Core\Session\AccountProxyInterface $account
   *   The account.
   *
   * @return bool
   *   Return TRUE if the account has the entity type's admin permission.
   */
  protected function isAdmin(ContentEntityInterface $entity, AccountProxyInterface $account = NULL) {
    $result = FALSE;
    if (!$account) {
      $account = $this->currentUser;
    }
    $entity_type = $entity->getEntityType();
    if ($entity_type instanceof EntityTypeInterface) {
      $permission = $entity_type->getAdminPermission();
      $result = $account->hasPermission($permission);
    }
    return (bool) $result;
  }

  /**
   * Helper function to return the Json Response.
   *
   * @param int $code
   *   The code status.
   * @param string $message
   *   A message.
   * @param array $data
   *   The original data pass to the endpoint.
   * @param bool $success
   *   The end point is successful ?
   * @param array $result
   *   Additionnal data to send.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   - status (array)
   *     - code (int : HTTP Code 200, 403, etc)
   *     - message (string : the reason)
   *   - response (array)
   *     - success (bool)
   *     - data (array the original data passed to the endpoint)
   *     - result : mixed (some useful data if necessary)
   */
  protected function getResponse($code, $message, array $data, $success = FALSE, array $result = []) {
    return new JsonResponse(
      [
        'status' => [
          'code' => $code,
          'message' => $this->t($message)->render(),
        ],
        'response' => [
          'success' => $success,
          'data' => $data,
          'result' => $result,
        ],
      ],
      $code
    );
  }

}
