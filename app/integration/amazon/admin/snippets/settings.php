<?php

Ucontext4a_Form::section('Amazon Settings');

Ucontext4a_Form::textField('Associate Tag', 'form_vars[ucontext4a_associate_tag]', @get_option('ucontext4a_associate_tag'), NULL, 'Your Amazon Affiliate/Associate Tag from <a href="https://affiliate-program.amazon.com/gp/associates/network/main.html" target="_blank">click here...</a>', TRUE);

Ucontext4a_Form::textField('Access Key ID', 'form_vars[ucontext4a_public_key]', @get_option('ucontext4a_public_key'), NULL, 'Your Amazon Access Key ID from <a href="https://portal.aws.amazon.com/gp/aws/securityCredentials" target="_blank">click here...</a>', TRUE);

Ucontext4a_Form::textField('Secret Access Key', 'form_vars[ucontext4a_private_key]', @get_option('ucontext4a_private_key'), NULL, 'Your Amazon Secret Access Key from <a href="https://portal.aws.amazon.com/gp/aws/securityCredentials" target="_blank">click here...</a>', TRUE);

require UCONTEXT4A_INTEGRATION_PATH.'/lists/amazon_site_list.php';
Ucontext4a_Form::selectField('Amazon Site', 'form_vars[ucontext4a_amazon_site]', @get_option('ucontext4a_amazon_site', 'US'), $amazon_site_list);

require UCONTEXT4A_INTEGRATION_PATH.'/lists/search_index_list.php';
Ucontext4a_Form::selectField('Default Category', 'form_vars[ucontext4a_dflt_search_index]', @get_option('ucontext4a_dflt_search_index'), $search_index_list);

require UCONTEXT4A_INTEGRATION_PATH.'/lists/condition_list.php';
Ucontext4a_Form::selectField('Default Condition', 'form_vars[ucontext4a_dflt_condition]', @get_option('ucontext4a_dflt_condition'), $condition_list);