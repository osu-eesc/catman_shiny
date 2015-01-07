<?php



/**
* Replacement for theme_form_element().
*/
// function catman_shiny_form_element($variables) {
//   // Ensure defaults.
//   $variables['element'] += array(
//     '#title_display' => 'before',
//   );

//   $element = $variables['element'];

//   // All elements using this for display only are given the "display" type.
//   if (isset($element['#format']) && $element['#format'] == 'html') {
//     $type = 'display';
//   }
//   else {
//     $type = (isset($element['#type']) && !in_array($element['#type'], array('markup', 'textfield'))) ? $element['#type'] : $element['#form_component']['type'];
//   }
//   $parents = str_replace('_', '-', implode('--', array_slice($element['#parents'], 1)));

//   $wrapper_classes = array(
//    'form-item',
//    'form-component',
//    'form-component-' . $type,
//   );
//   if (isset($element['#title_display']) && $element['#title_display'] == 'inline') {
//     $wrapper_classes[] = 'form-container-inline';
//   }
//   $output = '<div class="' . implode(' ', $wrapper_classes) . '" id="form-component-' . $parents . '">' . "\n";
//   $required = !empty($element['#required']) ? '<span class="form-required" title="' . t('This field is required.') . '">*</span>' : '';

//   // If #title is not set, we don't display any label or required marker.
//   if (!isset($element['#title'])) {
//     $element['#title_display'] = 'none';
//   }
//   $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
//   $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

//   switch ($element['#title_display']) {
//     case 'inline':
//     case 'before':
//     case 'invisible':
//       $output .= ' ' . theme('form_element_label', $variables);
//   if (!empty($element['#description'])) {
// $output .= ' <div class="description">' . $element['#description'] . "</div>\n";
//   }

//       $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
//       break;

//     case 'after':
//       $output .= ' ' . $prefix . $element['#children'] . $suffix;
//       $output .= ' ' . theme('form_element_label', $variables) . "\n";
//   if (!empty($element['#description'])) {
// $output .= ' <div class="description">' . $element['#description'] . "</div>\n";
//   }

//       break;

//     case 'none':
//     case 'attribute':
//       // Output no label and no required marker, only the children.
//       $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
//       break;
//   }

//   $output .= "</div>\n";

//   return $output;
// }



function catman_shiny_form_element($variables) {
  $element = &$variables['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  $attributes['class'] = array('form-item');
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      if (!empty($element['#description'])) {
        $output .= '<div class="description">' . $element['#description'] . "</div>\n";
      }
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;

      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      if (!empty($element['#description'])) {
        $output .= '<div class="description">' . $element['#description'] . "</div>\n";
      }
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  // if (!empty($element['#description'])) {
  //   $output .= '<div class="description">' . $element['#description'] . "</div>\n";
  // }

  $output .= "</div>\n";

  return $output;
}
