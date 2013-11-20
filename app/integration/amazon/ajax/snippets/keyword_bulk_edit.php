<?php

require UCONTEXT4A_INTEGRATION_PATH.'/lists/search_index_list.php';
$search_index_list = array_unshift_assoc($search_index_list, 'default', '-- Default Category --');
Ucontext4a_Form::selectField('Category', 'config[search_index]', @$form_vars['config']['search_index'], $search_index_list);

require UCONTEXT4A_INTEGRATION_PATH.'/lists/condition_list.php';
$condition_list = array_unshift_assoc($condition_list, 'default', '-- Default Condition --');
Ucontext4a_Form::selectField('Condition', 'config[condition]', @$form_vars['config']['condition'], $condition_list);