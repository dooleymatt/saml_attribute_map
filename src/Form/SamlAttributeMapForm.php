<?php

namespace Drupal\saml_attribute_map\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SamlAttributeMapForm.
 *
 * @package Drupal\saml_attribute_map\Form
 */
class SamlAttributeMapForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $saml_attribute_map = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $saml_attribute_map->label(),
      '#description' => $this->t("Label for the Saml attribute map."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $saml_attribute_map->id(),
      '#machine_name' => [
        'exists' => '\Drupal\saml_attribute_map\Entity\SamlAttributeMap::load',
      ],
      '#disabled' => !$saml_attribute_map->isNew(),
    ];

    $form['user_field'] = [
      '#type' => 'select',
      '#options' => $saml_attribute_map->getUserFields(),
      '#default_value' => $saml_attribute_map->getUserField(),
    ];

    $form['saml_attribute'] = [
      '#type' => 'textfield',
      '#title' => $this->t('SAML Attribute Name'),
      '#default_value' => $saml_attribute_map->getSamlAttribute(),
      '#maxlength' => 255,
    ];

    $form['enable_default_attribute'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable a default value for this field'),
      '#description' => $this->t('This allows you to specify a default value for this user account field if there is no value for the specified SAML attribute.'),
      '#default_value' => $saml_attribute_map->getSamlAttributeDefault(),
      '#maxlength' => 255,
    ];

    $form['saml_attribute_default'] = [
      '#type' => 'textfield',
      '#title' => $this->t('SAML Attribute default value'),
      '#default_value' => $saml_attribute_map->getSamlAttribute(),
      '#maxlength' => 255,
      '#states' => [
        'visible' => [
          ':input[name="enable_default_attribute"]' => array('checked' => TRUE),
        ]
      ]
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $saml_attribute_map = $this->entity;
    $status = $saml_attribute_map->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Saml attribute map.', [
          '%label' => $saml_attribute_map->getUserField(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Saml attribute map.', [
          '%label' => $saml_attribute_map->getUserField(),
        ]));
    }
    $form_state->setRedirectUrl($saml_attribute_map->toUrl('collection'));
  }

}
