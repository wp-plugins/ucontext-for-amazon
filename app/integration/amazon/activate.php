<?php

global $wpdb;

$wpdb->query('RENAME TABLE '.$wpdb->base_prefix.'uamazon_cache TO '.$wpdb->base_prefix.'ucontext4a_cache');
$wpdb->query('RENAME TABLE '.$wpdb->base_prefix.'uamazon_click_log TO '.$wpdb->base_prefix.'ucontext4a_click_log');
$wpdb->query('RENAME TABLE '.$wpdb->base_prefix.'uamazon_keyword TO '.$wpdb->base_prefix.'ucontext4a_keyword');
$wpdb->query('RENAME TABLE '.$wpdb->base_prefix.'uamazon_spider_agent TO '.$wpdb->base_prefix.'ucontext4a_spider_agent');

$wpdb->query('UPDATE '.$wpdb->base_prefix.'options SET option_name = REPLACE(option_name, "uamazon_", "ucontext4a_")');