<?php

namespace Drupal\saml_attribute_map\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountProxy;
use Drupal\Core\Session\AccountInterface;

class SamlAttributeManager {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;

  /**
   * SamlAttributeManager constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   *
   * @param \Drupal\Core\Session\AccountProxy $current_user
   *   The current user.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountProxy $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * Maps attribute values provided by the IdP to user profile fields.
   *
   * @param array $attributes
   *   An array of attributes for this user.
   *
   * @return bool|\Drupal\Core\Session\AccountInterface
   *   The updated user account, or false if nothing was updated.
   */
  public function mapAttributes($attributes) {
    $saml_attribute_maps = $this->entityTypeManager->getStorage('saml_attribute_map')
      ->loadMultiple();

    /** @var AccountInterface $user_account */
    $user_account = $this->currentUser->getAccount();

    /** @var \Drupal\saml_attribute_map\Entity\SamlAttributeMap $saml_attribute_map */
    foreach ($saml_attribute_maps as $saml_attribute_map) {
      $user_field = $saml_attribute_map->getUserField();
      $saml_attribute = $saml_attribute_map->getSamlAttribute();
      if ($attributes[$saml_attribute]) {
        $user_account->set($user_field, $attributes[$saml_attribute]);
        $account_updated = TRUE;
      }
    }
    return isset($account_updated) ? $user_account : FALSE;
  }
}