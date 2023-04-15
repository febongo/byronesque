<?php

if ( ! function_exists( 'corsen_core_add_team_single_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function corsen_core_add_team_single_meta_box() {
		$qode_framework = qode_framework_get_framework_root();
		$has_single     = corsen_core_team_has_single();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'team' ),
				'type'  => 'meta',
				'slug'  => 'team',
				'title' => esc_html__( 'Team Single', 'corsen-core' ),
			)
		);

		if ( $page ) {
			$section = $page->add_section_element(
				array(
					'name'        => 'qodef_team_general_section',
					'title'       => esc_html__( 'General Settings', 'corsen-core' ),
					'description' => esc_html__( 'General information about team member.', 'corsen-core' ),
				)
			);

			if ( $has_single ) {
				$section->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_team_single_layout',
						'title'       => esc_html__( 'Single Layout', 'corsen-core' ),
						'description' => esc_html__( 'Choose default layout for team single', 'corsen-core' ),
						'options'     => array(
							'' => esc_html__( 'Default', 'corsen-core' ),
						),
					)
				);
			}

			$section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_team_member_role',
					'title'       => esc_html__( 'Role', 'corsen-core' ),
					'description' => esc_html__( 'Enter team member role', 'corsen-core' ),
				)
			);

			$social_icons_repeater = $section->add_repeater_element(
				array(
					'name'        => 'qodef_team_member_social_icons',
					'title'       => esc_html__( 'Social Networks', 'corsen-core' ),
					'description' => esc_html__( 'Populate team member social networks info', 'corsen-core' ),
					'button_text' => esc_html__( 'Add New Network', 'corsen-core' ),
				)
			);

            $social_icons_repeater->add_field_element(
                array(
                    'field_type'  => 'select',
                    'name'        => 'qodef_enable_text_icon',
                    'title'       => esc_html__( 'Enable Text Icon', 'corsen-core' ),
                    'options'     => array(
                        'no'      => esc_html__( 'No', 'corsen-core' ),
                        'yes' => esc_html__( 'Yes', 'corsen-core' ),
                    ),
                )
            );

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'iconpack',
					'name'       => 'qodef_team_member_icon',
					'title'      => esc_html__( 'Icon', 'corsen-core' ),
                    'dependency'    => array(
                        'show' => array(
                            'qodef_enable_text_icon' => array(
                                'values'        => 'no',
                                'default_value' => '',
                            ),
                        ),
                    ),
				)
			);

            $social_icons_repeater->add_field_element(
                array(
                    'field_type' => 'text',
                    'name'       => 'qodef_team_member_icon_text',
                    'title'      => esc_html__( 'Text Icon', 'corsen-core' ),
                    'dependency'    => array(
                        'show' => array(
                            'qodef_enable_text_icon' => array(
                                'values'        => 'yes',
                                'default_value' => '',
                            ),
                        ),
                    ),
                )
            );

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_team_member_icon_link',
					'title'      => esc_html__( 'Icon Link', 'corsen-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_team_member_icon_target',
					'title'      => esc_html__( 'Icon Target', 'corsen-core' ),
					'options'    => corsen_core_get_select_type_options_pool( 'link_target' ),
				)
			);

			if ( $has_single ) {
				$section->add_field_element(
					array(
						'field_type'  => 'date',
						'name'        => 'qodef_team_member_birth_date',
						'title'       => esc_html__( 'Birth Date', 'corsen-core' ),
						'description' => esc_html__( 'Enter team member birth date', 'corsen-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_email',
						'title'       => esc_html__( 'E-mail', 'corsen-core' ),
						'description' => esc_html__( 'Enter team member e-mail address', 'corsen-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_address',
						'title'       => esc_html__( 'Address', 'corsen-core' ),
						'description' => esc_html__( 'Enter team member address', 'corsen-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_education',
						'title'       => esc_html__( 'Education', 'corsen-core' ),
						'description' => esc_html__( 'Enter team member education', 'corsen-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'file',
						'name'        => 'qodef_team_member_resume',
						'title'       => esc_html__( 'Resume', 'corsen-core' ),
						'description' => esc_html__( 'Upload team member resume', 'corsen-core' ),
						'args'        => array(
							'allowed_type' => '[application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
						),
					)
				);
			}

			// Hook to include additional options after module options
			do_action( 'corsen_core_action_after_team_meta_box_map', $page, $has_single );
		}
	}

	add_action( 'corsen_core_action_default_meta_boxes_init', 'corsen_core_add_team_single_meta_box' );
}
