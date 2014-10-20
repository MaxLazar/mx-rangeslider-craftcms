<?php
namespace Craft;

class MX_RangeSlider_RangeFieldType extends BaseFieldType
{

	/**
	 * Block type name
	 */
	public function getName()
	{
		return Craft::t('MX RangeSlider');
	}

	/**
	 * Save it
	 */
	public function defineContentAttribute()
	{
		return array(AttributeType::String, 'column' => ColumnType::Text);
	}

	/**
	 * Show date field
	 */
	public function getInputHtml($name, $value)
	{
		$settings = $this->getSettings();

		$id = craft()->templates->formatInputId($name);
		$namespacedId = craft()->templates->namespaceInputId($id);

		craft()->templates->includeJsResource('mx_rangeslider/js/ion.rangeSlider.min.js');
		craft()->templates->includeJsResource('mx_rangeslider/js/randeslider_helper.js');
		craft()->templates->includeCssResource('mx_rangeslider/css/ion.rangeSlider.css');
		craft()->templates->includeCssResource('mx_rangeslider/css/ion.rangeSlider.'.$settings['theme'].'.css');

		craft()->templates->includeJs("setTimeout(function() {
											$('#{$namespacedId}').ionRangeSlider()
									},150);
									new iSlider('#{$namespacedId}');
		");

		$SettingsFields = $this->getSettingsFields();

		$settings['from'] = $value['from'];
		$settings['to']   = $value['to'];

		return craft()->templates->render('mx_rangeslider/input', array(
			'name'           => $name,
			'inputId'        => str_replace(array('[', ']'), array('-', ''), $name),
			'settings'       => $settings,
			'SettingsFields' => $SettingsFields,
			'value'          => $value['from'].(($settings['type'] == 'double') ? ';'.$value['to'] : ''),
		));
	}

	/**
	 * Returns the field's settings HTML.
	 *
	 * @return string|null
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('mx_rangeslider/settings', array(
			'settings' => $this->getSettings(),
			'SettingsFields'  => $this->getSettingsFields()
		));
	}

	/**
	 * GetSettingsFields
	 * @return [type] [description]
	 */
	protected function getSettingsFields ()
	{
		$ft_parameters = array (
			"type" => array(
				'label'   => 'Range Type',
				'name'    => "type",
				'type'    => 'dropdown',
				'options' => array('single' => 'single','double' => 'double'),
				'default' => 'single',
				'info'    => 'Optional property, will select slider type from two options: single - for single range slider, or double - for double range slider'),
			"min" => array(
				'label'   => 'Min',
				'name'    => "min",
				'type'    => 'input',
				'default' => '10',
				'info'    => 'Optional property, automatically set from the value attribute of base input'),
			"max" => array(
				'label'   => 'Max',
				'name'    => "max",
				'type'    => 'input',
				'default' => '100',
				'info'    => 'Optional property, automatically set from the value attribute of base input'),
			"from" => array(
				'label'   => 'From',
				'name'    => "from",
				'type'    => 'input',
				'default' => '',
				'info'    => 'Optional property, on default has the same value as min. overwrite default FROM setting'),
			"to" => array(
				'label'   => 'To',
				'name'    => "to",
				'type'    => 'input',
				'default' => '',
				'info'    => 'Optional property, on default has the same value as max. overwrite default TO setting'),
			"step" => array(
				'label'   => 'Step',
				'name'    => "step",
				'type'    => 'input',
				'default' => '1',
				'info'    => 'Optional property, set slider step value'),
			"prefix" => array(
				'label'   => 'Prefix',
				'name'    => "prefix",
				'type'    => 'input',
				'default' => '',
				'info'    => 'Optional property, set prefix text to all values. For example: "$" will convert "100" in to "$100"'),
			"postfix" => array(
				'label'   => 'Postfix',
				'name'    => "postfix",
				'type'    => 'input',
				'default' => '',
				'info'    => 'Optional property, set postfix text to all values. For example: " €" will convert "100" in to "100 €"'),
			"maxPostfix" => array(
				'label'   => 'Max Postfix',
				'name'    => "maxPostfix",
				'type'    => 'input',
				'default' => '',
				'info'    => 'Optional property, set postfix text to maximum value. For example: maxPostfix - "+" will convert "100" to "100+"'),
			"hasGrid" => array(
				'label'   => 'Has Grid',
				'name'    => "hasGrid",
				'type'    => 'dropdown',
				'options' => array('false' => 'false','true' => 'true'),
				'default' => 'true',
				'info'    => 'Optional property, enables grid at the bottom of the slider (it adds 20px height and this can be customised through CSS)'),
			"gridMargin" => array(
				'label'   => 'Grid Margin',
				'name'    => "gridMargin",
				'type'    => 'input',
				'default' => '0',
				'info'    => 'Optional property, enables margin between slider corner and grid'),
			"hideMinMax" => array(
				'label'   => 'Hide MinMax',
				'name'    => "hideMinMax",
				'type'    => 'dropdown',
				'options' => array('false' => 'false','true' => 'true'),
				'default' => 'false',
				'info'    => 'Optional property, disables Min and Max fields.'),
			"hideFromTo" => array(
				'label'   => 'Hide FromTo',
				'name'    => "hideFromTo",
				'type'    => 'dropdown',
				'options' => array('false' => 'false','true' => 'true'),
				'default' => 'false',
				'info'    => 'Optional property, disables From an To fields.'),
			"prettify" => array(
				'label'   => 'Prettify',
				'name'    => "prettify",
				'type'    => 'dropdown',
				'options' => array('false' => 'false','true' => 'true'),
				'default' => 'true',
				'info'    => 'Optional property, allow to separate large numbers with spaces, eg. 10 000 than 10000'),
			"values" => array(
				'label'   => 'Values',
				'name'    => "values",
				'type'    => 'input',
				'default' => '',
				'info'    => 'Array of custom values: a, b, c etc.'),
			"theme" => array(
				'label'   => 'Theme',
				'name'    => "theme",
				'type'    => 'dropdown',
				'options' => array('skinFlat' => 'skinFlat', 'skinNice' => 'skinNice', 'skinSimple' => 'skinSimple'),
				'default' => 'skinFlat',
				'info'    => '')
			);

		return $ft_parameters;
	}

	public function prepValue($value)
	{
		$data    = array();
		$settings = $this->getSettings();
		$minmax  = explode( ";", $value );

		$minmax[1] = (!empty($value) && count($minmax) > 1) ? $minmax[1] : $minmax[0];

		$data['from']  = $minmax[0];
		$data['to']    = $minmax[1];
		$data['value'] = $minmax[0];

		if (trim($settings['values']) != '') {
			$labels              = explode( ",", $settings['values'] );
			$data['from_label']  = $labels[$data['from']];
			$data['to_label']    = $labels[$data['to']];
			$data['value_label'] = $labels[$data['to']];
		}

		return $data;
	}

	/**
	 * [defineSettings description]
	 * @return [type] [description]
	 */
   protected function defineSettings()
   {

   		//@TODO add AttributeType

   		$default = array ();

		foreach ($this->getSettingsFields() as $key => $value) {
			$default[$value['name']] = ['default' => $value['default']];
		}

		return $default;

    }

}