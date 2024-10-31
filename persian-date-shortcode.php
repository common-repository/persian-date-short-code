<?php
/*
	  Plugin Name: persian date shortcode 
	  Plugin URI: https://kanithemes.com
	  Version: 1.0
	  Author: esmail ebrahimi
	  Description:  Display persian date in several format in wordpress site
	  License: GPL2
	 */

//include the persian date class file
include_once('inc/pdsjdf.php');

//include the main class file
require_once("admin-page-class/admin-page-class.php");

$config = array(    
    'menu'           => 'settings',             
    'page_title'     => __('تاریخ شمسی','eepds'),  
    'capability'     => 'edit_themes',         
    'option_group'   => 'eepds_persian_date_shortcode_option',       
    'id'             => 'admin_page',            
    'fields'         => array(),            
    'local_images'   => false,          
    'use_with_theme' => false          
  );  
  
  $options_panel = new BF_Admin_Page_Class($config);
  $options_panel->OpenTabs_container('');
  $options_panel->TabsListing(array(
    'links' => array(
      'options_1' =>  __('تنظیمات افزونه','apc'),
	  'options_2' =>  __('راهنمای استفاده','apc'),
      'options_3' =>  __('درباره سازنده','apc')
    )
  ));
  
  $options_panel->OpenTab('options_1');
  $options_panel->Title(__("تنظیمات نمایش تاریخ شمسی","eepds"));
  $options_panel->addCheckbox('year',array('name'=> __('شیوه نمایش سال','eepds'), 'std' => false, 'desc' => __('سال به شکل حروف نمایش داده شود ؟ ','eepds')));
  $options_panel->addCheckbox('month',array('name'=> __('شیوه نمایش ماه','eepds'), 'std' => false, 'desc' => __('ماه به شکل حروف نمایش داده شود ؟','eepds')));
  $options_panel->addCheckbox('day',array('name'=> __('شیوه نمایش روز','eepds'), 'std' => false, 'desc' => __('روز به شکل حروف نمایش داده شود ؟','eepds')));
  $options_panel->addCheckbox('today',array('name'=> __('انتخاب کلمه "امروز"','eepds'), 'std' => false, 'desc' => __('می خواهید کلمه "امروز" در ابتدای تاریخ نمایش داده شود ؟','eepds')));  
  $options_panel->addCheckbox('bold',array('name'=> __('ضخامت نوشته تاریخ','eepds'), 'std' => false, 'desc' => __('می خواهید تاریخ به صورت ضخیم نمایش داده شود ؟','eepds')));  
  $options_panel->addText('seperator', array('name'=> __('جداکننده بخش های تاریخ','eepds'), 'std'=> ' ', 'desc' => __('کاراکتر جداکننده بخش های تاریخ را مشخص کنید . کاراکتر فاصله پیش فرض می باشد .','eepds')));
  $options_panel->addColor('color',array('name'=> __('رنگ تاریخ','eepds'), 'desc' => __('رنگ نوشته تاریخ را انتخاب کنید . رنگ سیاه پیش فرض می باشد .','eepds')));
  $options_panel->CloseTab();

  $options_panel->OpenTab('options_2');
  $options_panel->addParagraph(__("برای درج تاریخ در ابزارک ، نوشته یا صفحه از کد زیر استفاده کنید : <br/><br/><p style=\"text-align:left;direction:ltr;color:green;\"><b>[wikiwordpress]</b></p>","eepds"));
  $options_panel->addParagraph(__("برای درج تاریخ در پوسته سایت وردپرسی خود از کد زیر استفاده کنید : <br/><br/><p style=\"text-align:left;direction:ltr;color:green;\"><b>do_shortcode('[wikiwordpress]');</b></p>","eepds"));
  $options_panel->CloseTab();

  $options_panel->OpenTab('options_3');
  $options_panel->addParagraph(__("افزونه تاریخ شمسی برای وردپرس","eepds"));
  $options_panel->addParagraph(__("برنامه نویس : اسماعیل ابراهیمی","eepds"));
  $options_panel->addParagraph(__("جهت سفارش هرگونه افزونه یا پوسته وردپرس تماس بگیرید <br/><p style=\"text-align:left;direction:ltr;color:green;\"><b>09167119005</b><br/><b>kanithemes@gmail.com</b><br/><b>kanithemes@gmail.com</b></p>","eepds"));
  $options_panel->addParagraph(__("چنانچه سئوال یا مشکلی در رابطه با این افزونه دارید ، در سایت زیر مطرح کنید :  <br/><p style=\"text-align:left;direction:ltr;color:green;\"><b><a href=\"https://kanithemes.com\" target=\"_blanks\">kanithemes.com</a></b><br/><b><a href=\"https://kanithemes.com\" target=\"_blank\">kanithemes.com</a></b></p>","eepds"));
  $options_panel->CloseTab();

add_shortcode( 'wikiwordpress', 'wikiwordpress_shortcode' );

function is_color_correct($hex_color)
{
	if(preg_match('/^#[a-f0-9]{6}$/i', $hex_color)){
		return true;
	}else{
		return false;
	}
}

function wikiwordpress_shortcode()
{
	$att = get_option('eepds_persian_date_shortcode_option');
	$today=" امروز ";
	$day="";
	$month="";
	$year="";
	$persiandate="";
	$direction="ltr";
	
	$seperator=$att['seperator'];

	if ($att[day])
	{
		$day="J";
	}
	else
	{
		$day="d";
		$direction="rtl";
	}
	

	if ($att[month])
	{
		$month="F";
	}
	else
	{
		$month="m";
		$direction="rtl";
	}
	

	if ($att[year])
	{
		$year="V";
	}
	else
	{
		$year="Y";
		$direction="rtl";
	}
	
	$persiandate="<span dir={$direction} >";
	$persiandate .= pdsjdate("{$day}{$seperator}{$month}{$seperator}{$year}");
	$persiandate .="</span>";
	
	if($att['bold'])
	{
		$persiandate = '<strong>'.$persiandate.'</strong>';
		$today = '<strong>'. $today .'</strong>';
	}

	if(is_color_correct($att['color']))
	{
		$color=$att['color'];
		$persiandate ="<font color=\"{$color}\">".$persiandate.'</font>';
		$today ="<font color=\"{$color}\">".$today.'</font>';
	}
	
	if ($att['today'])
	{
		$persiandate= $today  . $persiandate;
	}
	
	return $persiandate;

}
?>