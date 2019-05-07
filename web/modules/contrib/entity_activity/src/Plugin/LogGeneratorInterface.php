<?php

namespace Drupal\entity_activity\Plugin;

use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;

/**
 * Defines an interface for Log generator plugins.
 */
interface LogGeneratorInterface extends ConfigurablePluginInterface, PluginInspectionInterface {

  /**
   * Build the configuration form.
   *
   * @param array $form
   *   The configuration form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form_state object.
   *
   * @return mixed
   *   The configuration form.
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state);

  /**
   * Validates a configuration form for this generator.
   *
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current form state.
   */
  public function validateConfigurationForm(array $form, FormStateInterface $form_state);

  /**
   * Retrieves the generator description.
   *
   * @return string
   *   The description of this generator.
   */
  public function getDescription();

  /**
   * Retrieves the generatorlabeln.
   *
   * @return string
   *   The label of this generator.
   */
  public function getLabel();

  /**
   * Provides a human readable summary of the log generator's configuration.
   */
  public function summary();

  /**
   * Retrieves the generator entity type definition.
   *
   * @return string
   *   The source entity type of this generator.
   */
  public function getSourceEntityType();

  /**
   * Retrieves the default bundles of the plugin definition.
   *
   * If the plugin definition is empty, retrieves all the bundles.
   *
   * @param bool $with_label
   *   Get an array of bundle with their label as value.
   *
   * @return array
   *   An array of bundles machine name for the entity type (with the label
   *   as value if with_label is TRUE).
   */
  public function getDefaultBundles($with_label = FALSE);

  /**
   * Retrieves the bundles set on the plugin configuration.
   *
   * @return array
   *   An array of bundles machine name for the entity type.
   */
  public function getBundles();

  /**
   * Retrieves the operation set on the plugin configuration.
   *
   * @return string
   *   The operation.
   */
  public function getOperation();

  /**
   * Should the generator use cron to generate log.
   *
   * @return bool
   *   Returns true when if the generator must use cron.
   */
  public function useCron();

  /**
   * Is the generator enabled ?
   *
   * @return bool
   *   Returns TRUE when if the generator is enabled.
   */
  public function isEnabled();

  /**
   * Is the generator act only for published entity ?
   *
   * @return bool
   *   Returns TRUE if the generator act only for published entity.
   */
  public function isPublished();

  /**
   * Gets the token type available for the generator.
   *
   * @return array
   *   An array of token types.
   */
  public function getTokenTypes();

  /**
   * Gets the entity reference fields given an entity type and a bundle.
   *
   * @param string $entity_type
   *   The entity type id.
   * @param string $bundle
   *   The bundle name.
   *
   * @return array
   *   An array of field label, keyed by the field name.
   */
  public function getEntityReferenceFields($entity_type, $bundle);

  /**
   * Gets the entity reference fields for an entity type and multiples bundles.
   *
   * @param string $entity_type
   *   The entity type id.
   * @param array $bundles
   *   An array of bundle name.
   *
   * @return array
   *   An array of field label, keyed by the field name.
   */
  public function getEntityReferenceFieldsOnMultipleBundles($entity_type, array $bundles = []);

  /**
   * Gets the source entity on which users have subscribed on.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The current entity on which the generator applies.
   *
   * @return array
   *   An array of entity id, keyed by the entity type id.
   */
  public function getEntitiesSubscribedOn(ContentEntityInterface $entity);

  /**
   * Gets the entity reference field names from which we want fetch entities.
   *
   * And gets the subscriptions on theses referenced entities to generate the
   * logs.
   *
   * @return array
   *   An array of field names.
   */
  public function getReferencedByFields();

  /**
   * Prepare settings to generate a log entity.
   *
   * Useful to generate log from a queue / cron and not immediately.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The content entity.
   * @param string $generator_id
   *   The generator ID from which the plugin has been instantiated.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user who perform the action.
   *
   * @return array
   *   The settings needed. See generateLog().
   */
  public function preGenerateLog(ContentEntityInterface $entity, $generator_id, AccountProxyInterface $current_user = NULL);

  /**
   * Generate a Log given settings based on a source entity.
   *
   * @param array $settings
   *   The settings needed as described below.
   *
   *   $settings['bundle'] = $entity->bundle();
   *   $settings['source_published'] = $source_published;
   *   $settings['source_entity_id'] = $entity->id();
   *   $settings['source_entity_type'] = $entity->getEntityTypeId();
   *   $settings['log_message'] = $this->getFinalLog($entity);
   *   $settings['entities_subscribed'] = $entities_by_type;
   *   $settings['current_user_id'] = $current_user_id.
   *
   * @return int
   *   The number of log generated.
   */
  public function generateLog(array $settings);

  /**
   * Get the log with token replaced.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The content entity.
   *
   * @return array
   *   The log message (array with value and format) with token replaced.
   */
  public function getFinalLog(ContentEntityInterface $entity);

  /**
   * Rewrite the final log message with a new based language log message.
   *
   * @param \Drupal\Core\Entity\ContentEntityInterface $entity
   *   The source entity
   * @param array $log_message
   *   The log message array in the new language.
   * @param int $current_user_id
   *   The current user id who did the operation.
   * @param int $current_date
   *   The timestamp when the operation has been done.
   * @param string $langcode
   *   The langcode to use for generate tokens.
   *
   * @return array
   *   The log message rewritten.
   */
  public function rewriteFinalLog(ContentEntityInterface $entity, array $log_message, $current_user_id, $current_date, $langcode);

}
