<?php

namespace Drupal\saml_attribute_map;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of Saml attribute map entities.
 */
class SamlAttributeMapListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    //$header['label'] = $this->t('Saml attribute map');
    //$header['id'] = $this->t('Machine name');
    $header['user_field'] = $this->t('User account field name');
    $header['saml_attribute'] = $this->t('SimpleSAMLphp attribute name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    //$row['label'] = $entity->label();
    //$row['id'] = $entity->id();
    $row['user_field'] = $entity->getUserField();
    $row['saml_attribute'] = $entity->getSamlAttribute();
    return $row + parent::buildRow($entity);
  }

}
