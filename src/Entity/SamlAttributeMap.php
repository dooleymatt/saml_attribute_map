<?php

namespace Drupal\saml_attribute_map\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Saml attribute map entity.
 *
 * @ConfigEntityType(
 *   id = "saml_attribute_map",
 *   label = @Translation("SimpleSAMLphp Auth Attribute Mappings"),
 *   handlers = {
 *     "list_builder" = "Drupal\saml_attribute_map\SamlAttributeMapListBuilder",
 *     "form" = {
 *       "add" = "Drupal\saml_attribute_map\Form\SamlAttributeMapForm",
 *       "edit" = "Drupal\saml_attribute_map\Form\SamlAttributeMapForm",
 *       "delete" = "Drupal\saml_attribute_map\Form\SamlAttributeMapDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\saml_attribute_map\SamlAttributeMapHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "saml_attribute_map",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/config/people/saml_attribute_map/{saml_attribute_map}",
 *     "add-form" = "/admin/config/people/saml_attribute_map/add",
 *     "edit-form" = "/admin/config/people/saml_attribute_map/{saml_attribute_map}/edit",
 *     "delete-form" = "/admin/config/people/saml_attribute_map/{saml_attribute_map}/delete",
 *     "collection" = "/admin/config/people/saml_attribute_map"
 *   }
 * )
 */
class SamlAttributeMap extends ConfigEntityBase implements SamlAttributeMapInterface {

  /**
   * The Saml attribute map ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Saml attribute map label.
   *
   * @var string
   */
  protected $label;

  /**
   * The user field to set.
   *
   * @var string
   */
  protected $user_field;

  /**
   * The SAML attribute.
   *
   * @var string
   */
  protected $saml_attribute;

  /**
   * Boolean indicating whether this map specifies a default attribute value.
   *
   * @var string
   */
  protected $enable_default_attribute;

  /**
   * The SAML attribute default value.
   *
   * @var string
   */
  protected $saml_attribute_default;

  /**
   * @param string $label
   */
  public function setLabel($label) {
    $this->label = $label;
  }

  /**
   * @return string
   */
  public function getUserField() {
    return $this->user_field;
  }

  /**
   * @param string $user_field
   */
  public function setUserField($user_field) {
    $this->user_field = $user_field;
  }

  /**
   * @return string
   */
  public function getSamlAttribute() {
    return $this->saml_attribute;
  }

  /**
   * @param string $saml_attribute
   */
  public function setSamlAttribute($saml_attribute) {
    $this->saml_attribute = $saml_attribute;
  }

  /**
   * @return string
   */
  public function getSamlAttributeDefault() {
    return $this->saml_attribute_default;
  }

  /**
   * @param string $saml_attribute_default
   */
  public function setSamlAttributeDefault($saml_attribute_default) {
    $this->saml_attribute_default = $saml_attribute_default;
  }

  /**
   * @return string
   */
  public function getEnableDefaultAttribute() {
    return $this->enable_default_attribute;
  }

  /**
   * @param string $enable_default_attribute
   */
  public function setEnableDefaultAttribute($enable_default_attribute) {
    $this->enable_default_attribute = $enable_default_attribute;
  }

  /**
   * @return array
   */
  public function getUserFields() {
    $user_field_names = [];
    $user_field_definitions = \Drupal::entityManager()->getFieldDefinitions('user', 'user');
    foreach ($user_field_definitions as $user_field_definition) {
      if($user_field_definition->getClass() == 'Drupal\Core\Field\BaseFieldDefinition') {
        $user_field_names[$user_field_definition->getName()] = $user_field_definition->getLabel()->render();
      }
      else {
        $user_field_names[$user_field_definition->getName()] = $user_field_definition->getLabel();
      }
    }
    return $user_field_names;
  }
}
