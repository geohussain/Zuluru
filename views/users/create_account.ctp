<?php
$this->Html->addCrumb (__('Users', true));
$this->Html->addCrumb (__('Create', true));

$short = Configure::read('organization.short_name');

$access = array(1);

// TODO: Handle more than one sport in a site
$sport = reset(array_keys(Configure::read('options.sport')));
Configure::load("sport/$sport");
?>

<p><?php __('To create a new account, fill in all the fields below and click \'Submit\' when done. Your account will be placed on hold until approved by an administrator. Once approved, you will have full access to the system.'); ?></p>
<p><?php printf(__('%s If you already have an account from a previous season, %s! Instead, please %s to regain access to your account.', true),
		$this->Html->tag('strong', __('NOTE', true) . ': '),
		$this->Html->tag('strong', __('DO NOT CREATE ANOTHER ONE', true)),
		$this->Html->link(__('follow these instructions', true), array('controller' => 'users', 'action' => 'reset_password'))
);
?></p>
<p><?php __('Note that email and phone publish settings below only apply to regular players. Captains will always have access to view the phone numbers and email addresses of their confirmed players. All Team Captains will also have their email address viewable by other players.'); ?></p>
<p><?php printf(__('If you have concerns about the data %s collects, please see our %s.', true),
		$short,
		$this->Html->tag('strong', $this->Html->link(__('Privacy Policy', true), Configure::read('urls.privacy_policy'), array('target' => '_new')))
);
?></p>

<div class="users form">
<?php echo $this->Form->create('Person', array('url' => Router::normalize($this->here)));?>
	<fieldset>
		<legend><?php __('Identity'); ?></legend>
	<?php
		echo $this->ZuluruForm->input('first_name', array(
			'after' => $this->Html->para (null, __('First (and, if desired, middle) name.', true)),
		));
		echo $this->ZuluruForm->input('last_name');
		echo $this->ZuluruForm->input("$user_model.$user_field", array(
			'label' => __('User Name', true),
		));
		echo $this->ZuluruForm->input('gender', array(
			'type' => 'select',
			'empty' => '---',
			'options' => Configure::read('options.gender'),
		));
	?>
	</fieldset>
	<fieldset>
		<legend><?php __('Password'); ?></legend>
	<?php
		echo $this->ZuluruForm->input("$user_model.passwd", array('type' => 'password', 'label' => 'Password'));
		echo $this->ZuluruForm->input("$user_model.confirm_passwd", array('type' => 'password', 'label' => 'Confirm Password'));
	?>
	</fieldset>
	<?php if (Configure::read('feature.affiliates')): ?>
	<fieldset>
		<legend><?php __('Affiliate'); ?></legend>
	<?php
		if (Configure::read('feature.multiple_affiliates')) {
			echo $this->ZuluruForm->input('Affiliate', array(
				'label' => __('Affiliates', true),
				'after' => $this->Html->para (null, __('Select all affiliates you are interested in.', true)),
				'multiple' => 'checkbox',
			));
		} else {
			echo $this->ZuluruForm->input('Affiliate', array(
				'empty' => '---',
				'multiple' => false,
			));
		}
	?>
	</fieldset>
	<?php endif; ?>
	<fieldset>
		<legend><?php __('Online Contact'); ?></legend>
	<?php
		echo $this->ZuluruForm->input("$user_model.$email_field");
		echo $this->ZuluruForm->input('publish_email', array(
			'label' => __('Allow other players to view my email address', true),
		));
		if (Configure::read('feature.gravatar')) {
			if (Configure::read('feature.photos')) {
				$after = sprintf(__('You can have an image shown on your account by uploading a photo directly, or by enabling this setting and then create a <a href="http://www.gravatar.com">gravatar.com</a> account using the email address you\'ve associated with your %s account.', true), Configure::read('organization.short_name'));
			} else {
				$after = sprintf(__('You can have an image shown on your account if you enable this setting and then create a <a href="http://www.gravatar.com">gravatar.com</a> account using the email address you\'ve associated with your %s account.', true), Configure::read('organization.short_name'));
			}
			echo $this->ZuluruForm->input('show_gravatar', array(
				'label' => __('Show Gravatar image for your account?', true),
				'after' => $this->Html->para (null, $after),
			));
		}
	?>
	</fieldset>
	<?php if (Configure::read('profile.addr_street') || Configure::read('profile.addr_city') ||
				Configure::read('profile.addr_prov') || Configure::read('profile.addr_country') ||
				Configure::read('profile.addr_postalcode')): ?>
	<fieldset>
		<legend><?php __('Street Address'); ?></legend>
	<?php
		if (Configure::read('profile.addr_street')) {
			echo $this->ZuluruForm->input('addr_street', array(
				'label' => __('Street and Number', true),
				'after' => $this->Html->para (null, __('Number, street name, and apartment number if necessary.', true)),
			));
		}
		if (Configure::read('profile.addr_city')) {
			echo $this->ZuluruForm->input('addr_city', array(
				'label' => __('City', true),
				'after' => $this->Html->para (null, __('Name of city.', true)),
			));
		}
		if (Configure::read('profile.addr_prov')) {
			echo $this->ZuluruForm->input('addr_prov', array(
				'label' => __('Province', true),
				'type' => 'select',
				'empty' => '---',
				'options' => $provinces,
				'after' => $this->Html->para (null, __('Select a province/state from the list', true)),
			));
		}
		if (Configure::read('profile.addr_country')) {
			echo $this->ZuluruForm->input('addr_country', array(
				'label' => __('Country', true),
				'type' => 'select',
				'empty' => '---',
				'options' => $countries,
				'after' => $this->Html->para (null, __('Select a country from the list.', true)),
			));
		}
		if (Configure::read('profile.addr_postalcode')) {
			echo $this->ZuluruForm->input('addr_postalcode', array(
				'label' => __('Postal Code', true),
				'after' => $this->Html->para (null, sprintf(__('Please enter a correct postal code matching the address above. %s uses this information to help locate new %s near its members.', true), $short, __(Configure::read('ui.fields'), true))),
			));
		}
	?>
	</fieldset>
	<?php endif; ?>
	<?php if (Configure::read('profile.home_phone') || Configure::read('profile.work_phone') ||
				Configure::read('profile.mobile_phone')): ?>
	<fieldset>
		<legend><?php __n('Telephone Number', 'Telephone Numbers', Configure::read('profile.home_phone') + Configure::read('profile.work_phone') + Configure::read('profile.mobile_phone')); ?></legend>
	<?php
		if (Configure::read('profile.home_phone')) {
			echo $this->ZuluruForm->input('home_phone', array(
				'after' => $this->Html->para (null, __('Enter your home telephone number. If you have only a mobile phone, enter that number both here and below.', true)),
			));
			echo $this->ZuluruForm->input('publish_home_phone', array(
				'label' => __('Allow other players to view home number', true),
			));
		}
		if (Configure::read('profile.work_phone')) {
			echo $this->ZuluruForm->input('work_phone', array(
				'after' => $this->Html->para (null, __('Enter your work telephone number (optional).', true)),
			));
			echo $this->ZuluruForm->input('work_ext', array(
				'label' => 'Work Extension',
				'after' => $this->Html->para (null, __('Enter your work extension (optional).', true)),
			));
			echo $this->ZuluruForm->input('publish_work_phone', array(
				'label' => __('Allow other players to view work number', true),
			));
		}
		if (Configure::read('profile.mobile_phone')) {
			echo $this->ZuluruForm->input('mobile_phone', array(
				'after' => $this->Html->para (null, __('Enter your cell or pager number (optional).', true)),
			));
			echo $this->ZuluruForm->input('publish_mobile_phone', array(
				'label' => __('Allow other players to view mobile number', true),
			));
		}
	?>
	</fieldset>
	<?php endif; ?>
	<?php if ($is_admin) : ?>
	<fieldset>
		<legend><?php __('Account Information'); ?></legend>
	<?php
		echo $this->ZuluruForm->input('group_id', array(
			'label' => __('Account Type', true),
			'type' => 'select',
			'empty' => '---',
			'options' => $groups,
		));
		echo $this->ZuluruForm->input('status', array(
			'type' => 'select',
			'empty' => '---',
			'options' => Configure::read('options.record_status'),
		));
	?>
	</fieldset>
	<?php endif; ?>
	<?php if (Configure::read('profile.skill_level') || Configure::read('profile.year_started') ||
				Configure::read('profile.birthdate') || Configure::read('profile.height') ||
				Configure::read('profile.shirt_size') || Configure::read('feature.dog_questions') ||
				in_array(Configure::read('profile.willing_to_volunteer'), $access) ||
				in_array(Configure::read('profile.contact_for_feedback'), $access)): ?>
	<fieldset>
		<legend><?php __('Player and Skill Information'); ?></legend>
	<?php
		if (Configure::read('profile.skill_level')) {
			if (Configure::read('sport.rating_questions')) {
				$after = $this->Html->para(null, __('Please use the questionnaire to ', true) . $this->Html->link (__('calculate your rating', true), '#', array('onclick' => 'dorating(); return false;')) . '.');
			} else {
				$after = null;
			}
			echo $this->ZuluruForm->input('skill_level', array(
				'type' => 'select',
				'empty' => '---',
				'options' => Configure::read('options.skill'),
				'after' => $after,
			));
		}
		if (Configure::read('profile.year_started')) {
			echo $this->ZuluruForm->input('year_started', array(
				'type' => 'select',
				'options' => $this->Form->__generateOptions('year', array(
						'min' => Configure::read('options.year.started.min'),
						'max' => Configure::read('options.year.started.max'),
						'order' => 'desc'
				)),
				'empty' => '---',
				'after' => $this->Html->para(null, 'The year you started playing in <strong>this</strong> league.'),
			));
		}
		if (Configure::read('profile.birthdate')) {
			if (Configure::read('feature.birth_year_only')) {
				echo $this->ZuluruForm->input('birthdate', array(
					'dateFormat' => 'Y',
					'minYear' => Configure::read('options.year.born.min'),
					'maxYear' => Configure::read('options.year.born.max'),
					'after' => $this->Html->para(null, __('Please enter a correct birthdate; having accurate information is important for insurance purposes.', true)),
				));
				echo $this->Form->hidden('birthdate.month', array('value' => 1));
				echo $this->Form->hidden('birthdate.day', array('value' => 1));
			} else {
				echo $this->ZuluruForm->input('birthdate', array(
					'minYear' => Configure::read('options.year.born.min'),
					'maxYear' => Configure::read('options.year.born.max'),
					'after' => $this->Html->para(null, __('Please enter a correct birthdate; having accurate information is important for insurance purposes.', true)),
				));
			}
		}
		if (Configure::read('profile.height')) {
			if (Configure::read('feature.units') == 'Metric') {
				$units = __('centimeters', true);
			} else {
				$units = __('inches (5 feet is 60 inches; 6 feet is 72 inches)', true);
			}
			echo $this->ZuluruForm->input('height', array(
				'size' => 6,
				'after' => $this->Html->para(null, sprintf(__('Please enter your height in %s. This is used to help generate even teams for hat leagues.', true), $units)),
			));
		}
		if (Configure::read('profile.shirt_size')) {
			echo $this->ZuluruForm->input('shirt_size', array(
				'type' => 'select',
				'empty' => '---',
				'options' => Configure::read('options.shirt_size'),
			));
		}
		if (Configure::read('feature.dog_questions')) {
			echo $this->ZuluruForm->input('has_dog');
		}
		if (Configure::read('profile.willing_to_volunteer')) {
			echo $this->ZuluruForm->input('willing_to_volunteer', array(
				'label' => sprintf(__('Can %s contact you about volunteering?', true), $short),
			));
		}
		if (Configure::read('profile.contact_for_feedback')) {
			echo $this->ZuluruForm->input('contact_for_feedback', array(
				'label' => sprintf(__('From time to time, %s would like to contact members with information on our programs and to solicit feedback. Can %s contact you in this regard?', true), $short, $short),
			));
		}
	?>
	</fieldset>
	<?php endif; ?>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

<?php
if (Configure::read('profile.skill_level') && Configure::read('sport.rating_questions')) {
	echo $this->element('people/rating', array('sport' => $sport, 'field' => '#PersonSkillLevel'));
}
?>
