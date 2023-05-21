<?php
	$options = array();
	$options[] = array(
		'name' 	=> 'الروابط الاجتماعيه',
		'id' 	=> 'Social',
		'type' 	=> 'tab',
		'icon' 	=> 'fa fa-share-alt',
	);
	$options[] = array(
		'name' 	=> 'الارشفه',
		'id' 	=> 'seo',
		'type' 	=> 'tab',
		'icon' 	=> 'fa fa-rocket',
	);
	$options[] = array(
		'name' 	=> 'التصميم',
		'id' 	=> 'design',
		'type'	=> 'tab',
		'icon' 	=> 'fa fa-paint-brush',
	);
	$options[] = array(
		'name' 	=> 'الاعلانات',
		'id' 	=> 'ads',
		'type' 	=> 'tab',
		'icon' 	=> 'fa fa-th-large',
	);
	$options[] = array(
		'name' 	=> 'الروابط',
		'id' 	=> 'links',
		'type' 	=> 'tab',
		'icon' 	=> 'fa fa-link',
	);
	$options[] = array(
		'name' 	=> 'عنوان الصفحة الرئيسية',
		'id' 	=> 'homeTitle',
		'type' 	=> 'text',
		'to' 	=> 'seo'
	);
	$options[] = array(
		'name' 	=> 'وصف الصفحة الرئيسية',
		'id' 	=> 'homeDesc',
		'type' 	=> 'textarea',
		'to' 	=> 'seo'
	);
	$options[] = array(
		'name' 	=> 'لوجو الموقع',
		'id' 	=> 'logo',
		'type' 	=> 'upload',
		'to' 	=> 'design'
	);
	$options[] = array(
		'name' 	=> 'رابط الفيس بوك',
		'id' 	=> 'facebook',
		'type' 	=> 'text',
		'to' 	=> 'Social'
	);
	$options[] = array(
		'name' 	=> 'رابط جوجل بلس',
		'id' 	=> 'google',
		'type' 	=> 'text',
		'to' 	=> 'Social'
	);
	$options[] = array(
		'name' 	=> 'رابط تويتر',
		'id' 	=> 'twitter',
		'type' 	=> 'text',
		'to' 	=> 'Social'
	);
	$options[] = array(
		'name' 	=> 'رابط يوتيوب',
		'id' 	=> 'youtube',
		'type' 	=> 'text',
		'to' 	=> 'Social'
	);
	$options[] = array(
		'name' 	=> 'كود اعلانى فى الهيدر',
		'id' 	=> 'headerCodeAD',
		'type' 	=> 'textarea',
		'to' 	=> 'ads',
	);
	$options[] = array(
		'name' 	=> 'كود اعلانى فى الفوتر',
		'id' 	=> 'footerCodeAD',
		'type' 	=> 'textarea',
		'to' 	=> 'ads',
	);
	$options[] = array(
		'name' 	=> 'اعلان يمين الهيدر',
		'id' 	=> 'headerRightAD',
		'type' 	=> 'upload',
		'to' 	=> 'ads',
	);
	$options[] = array(
		'name' 	=> 'رابط اعلان يمين الهيدر',
		'id' 	=> 'headerRightADUrl',
		'type' 	=> 'text',
		'to' 	=> 'links',
	);
	$options[] = array(
		'name' 	=> 'اعلان منتصف الهيدر',
		'id' 	=> 'headerCenterAD',
		'type' 	=> 'upload',
		'to' 	=> 'ads',
	);
	$options[] = array(
		'name' 	=> 'رابط اعلان منتصف الهيدر',
		'id' 	=> 'headerCenterADUrl',
		'type' 	=> 'text',
		'to' 	=> 'links',
	);
	$options[] = array(
		'name' 	=> 'اعلان يسار الهيدر',
		'id' 	=> 'headerLeftAD',
		'type' 	=> 'upload',
		'to' 	=> 'ads',
	);
	$options[] = array(
		'name' 	=> 'رابط اعلان يسار الهيدر',
		'id' 	=> 'headerLeftADUrl',
		'type' 	=> 'text',
		'to' 	=> 'links',
	);
	$options[] = array(
		'name' 	=> 'اعلان يمين الفوتر',
		'id' 	=> 'footerRightAD',
		'type' 	=> 'upload',
		'to' 	=> 'ads',
	);
	$options[] = array(
		'name' 	=> 'رابط اعلان يمين الفوتر',
		'id' 	=> 'footerRightADUrl',
		'type' 	=> 'text',
		'to' 	=> 'links',
	);
	$options[] = array(
		'name' 	=> 'اعلان منتصف الفوتر',
		'id' 	=> 'footerCenterAD',
		'type' 	=> 'upload',
		'to' 	=> 'ads',
	);
	$options[] = array(
		'name' 	=> 'رابط اعلان منتصف الفوتر',
		'id' 	=> 'footerCenterADUrl',
		'type' 	=> 'text',
		'to' 	=> 'links',
	);
	$options[] = array(
		'name' 	=> 'اعلان يسار الفوتر',
		'id' 	=> 'footerLeftAD',
		'type' 	=> 'upload',
		'to' 	=> 'ads',
	);
	$options[] = array(
		'name' 	=> 'رابط اعلان يسار الفوتر',
		'id' 	=> 'footerLeftADUrl',
		'type' 	=> 'text',
		'to' 	=> 'links',
	);