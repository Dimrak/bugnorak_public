<?php
namespace App\Helper;
class FormHelper
{
   public function __construct($action, $method, $class = '')
   {
      $this->html = '<form class="'.$class.'" action="'.$action.'" method="'.$method.'">';
   }  
   public function addCheckBox($attributes, $label = ''){
      $html = '';
      if($label != ''){
         $html .= '<label>'.$label.'</label>';
      }
      $html .= '<input ';
      foreach ($attributes as $key => $value){
         $html .= ' '.$key.'="'.$value.'"';
      }
      $html .= ' >';
      $this->html .= $html;
      return $this;
      
   }
   public function addInput($attributes, $class = '',$label = '', $wrapper = '')
   {
      $html = '';
      if ($label != ''){
         if (array_key_exists('id', $attributes)){
            $for = 'for="' . $attributes['id'] . '"';
         }else {
            $for = '';
         }
         $html .= '<label ' . $for . ' class="complex-label">' . ucfirst($label) .  '</label>';
      }
            
      $html.= '<input '; //<input name,type,placeholder>
      foreach ($attributes as $key => $element){
         
         $html .= ' '.$key.'="'.$element.'"';
         //           $html .= ' '.'checked="' . $statement .'"';
      }
      $html .= ' class="' . $class . '"';
      $html .= ' autocomplete="' . 'off' . '"';
      $html .= ' >';
      if($wrapper != ''){ 
         $html = $this->addWrapper($wrapper, $html);
      }
   
      $this->html .= $html;
      return $this;
   }
   public function addSubmit($attributes, $class = ''){
      $html = '';
      $html.= '<input ';
      foreach ($attributes as $key => $element){
         $html .= $key . '="' . $element . '"';
      }
      $html .= ' class="' . $class . '"';
      $html .= '>';
      $this->html .= $html;
      // dd($this);
      return $this;
   }
   public function addTextarea($attributes, $class = '',$content = '', $label = '' ){
      $html = '';
      if ($label != ''){
         if (array_key_exists('id', $attributes)){
            $for = 'for="' . $attributes['id'] . '"';
         }else {
            $for = '';
         }
         $html .= '<label ' . $for . 'class="'. $class .'"'.'>' . ucfirst($label) .  '</label>';
      }
      
      $html .= '<textarea';
      foreach ($attributes as $key => $element){
         $html .= ' '. $key . '="' . $element . '"';
      }
      $html .= 'class="' . $class . '"';
      $html .= '>';
      $html .= $content;
      $html .= '</textarea>';
      $this->html .= $html;
      return $this;
   }     
   public function addOption($options){
      $html = '';
      foreach ($options as $value => $option) {
         $html .= '<option value="' . $value . '"';
         $html .= ' >';
         $html .= ucfirst($option);
         $html .= '</option>';
      }
      $this->html .= $html;
      return $this;
   } 
   public function addSelect($options, $name, $id, $class = '', $label = '')
   {
      $html = '';
      if($label != ''){
         $html .= '<label>'.$label.'</label>';
      }
      $html .= '<select name="' . $name . '"' . ' ' .'class="' . $class . '"' . ' ' .'id="' . $id . '"' . '>';
      foreach ($options as $key => $option) {
         $html .= '<option value="' . $key . '"' . ' >';
         $html .= ucfirst($option) . '</option>';;
      }      
      $html .= '</select>';
      $this->html .= $html;
      return $this;
   }  
   public function add_contries_select($class = '', $active = '')
   {
      $html = '';
      $html .= '<select name="country" class="'. $class .'">';
      $countries = ['Afganistan', 'Afghanistan', 'Albania', 'Algeria', 'American Samoa', 'Andorra', 'Angola', 'Anguilla', 'Antigua & Barbuda', 'Argentina', 'Armenia', 'Aruba', 'Australia', 'Austria', 'Azerbaijan', 'Bahamas', 'Bahrain', 'Bangladesh', 'Barbados', 'Belarus', 'Belgium', 'Belize', 'Benin', 'Bermuda', 'Bhutan', 'Bolivia', 'Bonaire', 'Bosnia & Herzegovina', 'Botswana', 'Brazil', 'British Indian Ocean Ter', 'Brunei', 'Bulgaria', 'Burkina Faso', 'Burundi', 'Cambodia', 'Cameroon', 'Canada', 'Canary Islands', 'Cape Verde', 'Cayman Islands', 'Central African Republic', 'Chad', 'Channel Islands', 'Chile', 'China', 'Christmas Island', 'Cocos Island', 'Colombia', 'Comoros', 'Congo', 'Cook Islands', 'Costa Rica', 'Cote DIvoire', 'Croatia', 'Cuba', 'Curaco', 'Curacao', 'Cyprus', 'Czech Republic', 'Denmark', 'Djibouti', 'Dominica', 'Dominican Republic', 'East Timor', 'Ecuador', 'Egypt', 'El Salvador', 'Equatorial Guinea', 'Eritrea', 'Estonia', 'Ethiopia', 'Falkland Islands', 'Faroe Islands', 'Fiji', 'Finland', 'France', 'French Guiana', 'French Polynesia', 'French Southern Ter', 'Gabon', 'Gambia', 'Georgia', 'Germany', 'Ghana', 'Gibraltar', 'Great Britain', 'Greece', 'Greenland', 'Grenada', 'Guadeloupe', 'Guam', 'Guatemala', 'Guinea', 'Guyana', 'Haiti', 'Hawaii', 'Honduras', 'Hong Kong', 'Hungary', 'Iceland', 'Indonesia', 'India', 'Iran', 'Iraq', 'Ireland', 'Isle of Man', 'Israel', 'Italy', 'Jamaica', 'Japan', 'Jordan', 'Kazakhstan', 'Kenya', 'Kiribati', 'Korea North', 'Korea Sout', 'Korea South', 'Kuwait', 'Kyrgyzstan', 'Laos', 'Latvia', 'Lebanon', 'Lesotho', 'Liberia', 'Libya', 'Liechtenstein', 'Lithuania', 'Luxembourg', 'Macau', 'Macedonia', 'Madagascar', 'Malaysia', 'Malawi', 'Maldives', 'Mali', 'Malta', 'Marshall Islands', 'Martinique', 'Mauritania', 'Mauritius', 'Mayotte', 'Mexico', 'Midway Islands', 'Moldova', 'Monaco', 'Mongolia', 'Montserrat', 'Morocco', 'Mozambique', 'Myanmar', 'Nambia', 'Nauru', 'Nepal', 'Netherland Antilles', 'Netherlands', 'Netherlands (Holland, Europe)', 'Nevis', 'New Caledonia', 'New Zealand', 'Nicaragua', 'Niger', 'Nigeria', 'Niue', 'Norfolk Island', 'Norway', 'Oman', 'Pakistan', 'Palau Island', 'Palestine', 'Panama', 'Papua New Guinea', 'Paraguay', 'Peru', 'Phillipines', 'Philippines', 'Pitcairn Island', 'Poland', 'Portugal', 'Puerto Rico', 'Qatar', 'Republic of Montenegro', 'Republic of Serbia', 'Reunion', 'Romania', 'Russia', 'Rwanda', 'St Barthelemy', 'St Eustatius', 'St Helena', 'St Kitts-Nevis', 'St Lucia', 'St Maarten', 'St Pierre & Miquelon', 'St Vincent & Grenadines', 'Saipan', 'Samoa', 'Samoa American', 'San Marino', 'Sao Tome & Principe', 'Saudi Arabia', 'Senegal', 'Seychelles', 'Sierra Leone', 'Singapore', 'Slovakia', 'Slovenia', 'Solomon Islands', 'Somalia', 'South Africa', 'Spain', 'Sri Lanka', 'Sudan', 'Suriname', 'Swaziland', 'Sweden', 'Switzerland', 'Syria', 'Tahiti', 'Taiwan', 'Tajikistan', 'Tanzania', 'Thailand', 'Togo', 'Tokelau', 'Tonga', 'Trinidad & Tobago', 'Tunisia', 'Turkey', 'Turkmenistan', 'Turks & Caicos Is', 'Tuvalu', 'Uganda', 'United Kingdom', 'Ukraine', 'United Arab Erimates', 'United Arab Emirates', 'United States of America', 'Uraguay', 'Uruguay', 'Uzbekistan', 'Vanuatu', 'Vatican City State', 'Venezuela', 'Vietnam', 'Virgin Islands (Brit)', 'Virgin Islands (USA)', 'Wake Island', 'Wallis & Futana Is', 'Yemen', 'Zaire', 'Zambia', 'Zimbabwe'
      ];
      foreach ($countries as $country) {
         if ($country == $active) {
            $html .= '<option value="' . $active . '" selected>'. $active .'</option>';
         }else{
            $html .= '<option value="' . $country . '">'. $country .'</option>';
         }
      };
      $html .= '</select>';
      $this->html .= $html;
      return $this;
   } 
   public function addWrapper($wrapper, $html)
   {
      $html = '<div class="'.$wrapper.'">'.$html.'</div>';
      return $html;
   }     
   public function get()
   {
      $this->html .= '</form>';
      return $this->html;
   }     
   public function addTitle($name, $class = '')
   {
      $html = '';
      $html .= '<h3 '.  ' class="' . $class . '"' .'>'; 
      $html .= ucfirst($name) . '</h3>';
      $this->html .= $html;
      return $this;    
   }
   public function addDivBox($class = '', $content = '', $id = '')
   {
      $html = '';
      $html .= '<div '. 'class="' . $class . '"' . 'id="'. $id . '"' .'>';
      $html .= $content . ' ';
      $html .= '</div>';
      $this->html .= $html;
      return $this;
   }
   public function addInputLogin($attributes, $class = '')
   {
      $html = '';
      $html.= '<input ';
      foreach ($attributes as $key => $element){
         $html .= ' '.$key.'="'.$element.'"';
      }
      $html .= ' class="' . $class . '"';
      $html .= ' >';
      $this->html .= $html;
      return $this;
   }
}