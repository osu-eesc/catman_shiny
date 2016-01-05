<?php

/**
 * @file
 * Customize the navigation shown when editing or viewing submissions.
 *
 * Available variables:
 * - $node: The node object for this webform.
 * - $mode: Either "form" or "display". May be other modes provided by other
 *          modules, such as "print" or "pdf".
 * - $submission: The Webform submission array.
 * - $submission_content: The contents of the webform submission.
 * - $submission_navigation: The previous submission ID.
 * - $submission_information: The next submission ID.
 */

// dpm($submission, 'submission array');
// dpm($submission_information, 'submission_information array');
// dpm($submission_content, 'submission_content array');


?>

<?php if ($mode == 'display' || $mode == 'form'): ?>
  <div class="clearfix">
    <?php print $submission_actions; ?>
    <?php print $submission_navigation; ?>
  </div>
<?php endif; ?>

<?php //print $submission_information; ?>

<h2 class="title webform-proposal-id">
  <?php print 'EESC Project Request #' . $submission->sid; ?>
</h2>

<p class="submitted-date">
  <?php print 'Submitted: ' . date('l, F j, Y, g:i a', $submission->submitted); ?>
</p>

<div class="webform-submission">
  <?php print render($submission_content); ?>
</div>

<?php if ($mode == 'display' || $mode == 'form'): ?>
  <div class="clearfix">
    <?php print $submission_navigation; ?>
  </div>
<?php endif; ?>
