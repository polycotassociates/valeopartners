<?php

namespace Drupal\vp_views\Plugin\views\filter;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\views\Plugin\views\filter\Combine;
/**
 * Filter handler which allows to search on multiple fields.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsFilter("array_combine")
 */
class ArrayCombine extends Combine {

  /**
   * Filters by one or more words.
   *
   * By default opContainsWord uses add_where, that doesn't support complex
   * expressions.
   *
   * @param string $expression
   */
  protected function opContainsWord($expression) {
    $placeholder = $this->placeholder();

    // Don't filter on empty strings.
    if (empty($this->value)) {
      return;
    }

    // Here's the only change.
    $this->value = implode(" ", $this->value );

    // Match all words separated by spaces or sentences encapsulated by double
    // quotes.
    preg_match_all(static::WORDS_PATTERN, ' ' . $this->value, $matches, PREG_SET_ORDER);

    // Switch between the 'word' and 'allwords' operator.
    $type = $this->operator == 'word' ? 'OR' : 'AND';
    $group = $this->query->setWhereGroup($type);
    $operator = Database::getConnection()->mapConditionOperator('LIKE');
    $operator = isset($operator['operator']) ? $operator['operator'] : 'LIKE';

    foreach ($matches as $match_key => $match) {
      $temp_placeholder = $placeholder . '_' . $match_key;
      // Clean up the user input and remove the sentence delimiters.
      $word = trim($match[2], ',?!();:-"');
      $this->query->addWhereExpression($group, "$expression $operator $temp_placeholder", [$temp_placeholder => '%' . Database::getConnection()->escapeLike($word) . '%']);
    }
  }

}
