<?php echo $value ?>
<?php echo $page->test->value ?>
<?php echo $page->test->value('hmm') ?>
<?php echo $page->test->value ? $page->test->value : "durka" ?>
<?php echo $page->test->value . "durka" . $page->test->another_value ?>
<?php echo e($page->test->value) ?>