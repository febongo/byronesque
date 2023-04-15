<?php
$uniqIndex = uniqid('wcuCurrencySwitcherSimpleDropdown_');

foreach($this->designTab as $p) {
	// create variable like param name with param value
	${$p} = $this->optionsParams['currency_switcher']['design_tab'][$p]['params']['value'];
}
foreach($this->displayRulesTab as $p) {
	// create variable like param name with param value
	${$p} = $this->optionsParams['currency_switcher']['display_rules_tab'][$p]['params']['value'];
}
?>

<style>

<?php if ($show_on_screen && $show_on_screen_compare && $show_on_screen_value) {?>
	<?php if ($show_on_screen_compare === 'less') {
		$show_on_screen_compare = 'max-width';
	} else {
		$show_on_screen_compare = 'min-width';
	}?>
	.wcuCurrencySwitcher.dropdown {
		display:none !important;
	}
	@media (<?php echo $show_on_screen_compare ?>:<?php echo $show_on_screen_value?>px) {
		.wcuCurrencySwitcher.dropdown {
			display:inline-block !important;
		}
<?php }?>


	<?php if (!$this->isShortcode) { ?>
		<?php if (!wp_is_mobile()) { ?>
			<?php echo '.' .  $uniqIndex ?>.wcuCurrencySwitcher.dropdown.left, .wcuCurrencySwitcher.dropdown.right {
				top: <?php echo $vertical_offset_desktop?><?php echo $vertical_offset_desktop_dimension?> !important;
			}
			<?php echo '.' . $uniqIndex ?>.wcuCurrencySwitcher.dropdown.left {
				left: <?php echo $horizontal_offset_desktop?><?php echo $horizontal_offset_desktop_dimension?> !important;
			}
			<?php echo '.' . $uniqIndex ?>.wcuCurrencySwitcher.dropdown.right {
				right: <?php echo $horizontal_offset_desktop?><?php echo $horizontal_offset_desktop_dimension?> !important;
			}
		<?php } else { ?>
			<?php echo '.' . $uniqIndex ?>.wcuCurrencySwitcher.dropdown.left, .wcuCurrencySwitcher.dropdown.right {
				top: <?php echo $vertical_offset_mobile?><?php echo $vertical_offset_mobile_dimension?> !important;
			}
			<?php echo '.' . $uniqIndex ?>.wcuCurrencySwitcher.dropdown.left {
				left: <?php echo $horizontal_offset_mobile?><?php echo $horizontal_offset_mobile_dimension?> !important;
			}
			<?php echo '.' . $uniqIndex ?>.wcuCurrencySwitcher.dropdown.right {
				right: <?php echo $horizontal_offset_mobile?><?php echo $horizontal_offset_mobile_dimension?> !important;
			}
		<?php } ?>
	<?php } ?>

	<?php
	if ($this->isShortcode) {
		echo '.' . $uniqIndex ?>.wcuCurrencySwitcher.dropdown {
			position: static !important;
		}
	<?php
	}
	?>

	.wcuCurrencySwitcher.dropdown li {
		background-color: <?php echo $bg_color?>;
		color: <?php echo $txt_color?>;
		margin: <?php echo $icon_spacing?>px;
	}
	.wcuCurrencySwitcher.dropdown li:hover {
		background-color: <?php echo $bg_color_h?>;
		color: <?php echo $txt_color_h?>;
	}
	.wcuCurrencySwitcher.dropdown .wcuCurrent {
		background-color: <?php echo $bg_color_cur?>;
		color: <?php echo $txt_color_cur?>;
	}
	.wcuCurrencySwitcher.dropdown.wcuCsdShowBorder_1 li {
		border:1px solid <?php echo $bor_color ?>;
	}
	.wcuCurrencySwitcher.dropdown.wcuCsdShowBorder_1 li:last-child {
		border-right:1px solid <?php echo $bor_color ?>;
	}
	.wcuCurrencySwitcher.dropdown.wcuCsdIconType_rectangular li {
		border-radius: <?php echo $border_radius . $border_radius_dimension ?>;
		-moz-border-radius:  <?php echo $border_radius . $border_radius_dimension ?>;
		-webkit-border-radius:  <?php echo $border_radius . $border_radius_dimension ?>;
	}
    .wcuCurrencySwitcher.dropdown.wcuCsdToggleSwitcher_on_hover ul:hover li {
        color: <?php echo $txt_color?>;
    }
    .wcuCsdToggleSwitcherClick.dropdown ul li{
        color: <?php echo $txt_color?> !important;
    }
    .wcuCurrencySwitcher.dropdown ul:hover li.wcuCurrent {
        color: <?php echo $txt_color_cur?>;
    }
    .wcuCsdToggleSwitcherClick.dropdown ul li.wcuCurrent{
        color: <?php echo $txt_color_cur?> !important;
    }
    .wcuCurrencySwitcher.dropdown.dropdown ul:hover li:hover {
        color: <?php echo $txt_color_h?>;
    }
    .wcuCsdToggleSwitcherClick.dropdown ul li:hover{
        color: <?php echo $txt_color_h?> !important;
    }
    .wcuCurrencySwitcher.dropdown.dropdown.wcuCsdIconType_circle.wcuCsdShowBorder_1 ul li {
        border-bottom:1px solid <?php echo $bor_color ?> !important;
    }
    .wcuCurrencySwitcher.dropdown.horizontal.wcuCsdShowBorder_1 li {
        border-bottom:1px solid <?php echo $bor_color ?> !important;
    }
<?php if ($show_on_screen) {?>
}
<?php }?>

	<?php
	if ($this->isShortcode) {
		$viewClass = 'wcuShortcodeView';
		if ('extended' === $this->mode) {
			$show = '';
		}
	} else {
		$viewClass = 'wcuClasscodeView';
	}

	?>

</style>
<div class="wcuCurrencySwitcherSimpleDropdown <?php echo $uniqIndex; ?> <?php echo $viewClass; ?> wcuCurrencySwitcher dropdown <?php echo $side_simple?> <?php echo $layout?> wcuCsdShow_<?php echo $show?> wcuCsdToggleSwitcher_<?php echo $toggle_switcher?> wcuCsdIconType_<?php echo $icon_type?> wcuCsdIconSize_<?php echo $icon_size?> wcuCsdShowBorder_<?php echo $show_border?> <?php echo $this->mode; ?>" data-type="<?php echo $type?>">
	<?php dispatcherWcu::doAction('beforeCurrencySwitcherList', $this->optionsParams); ?>
	<ul>

        <?php if ( ( ($layout === "horizontal") && ($side_simple === "left") ) || ($layout === "vertical") ) { ?>

        <li class="wcuCurrencySwitcherSimpleDropdownClose">
            <i class="fa fa-times" aria-hidden="true"></i>
        </li>

			<li class="wcuCurrent" data-currency="<?php
			echo $this->currentCurrency ?>">
				<?php
				echo ( is_array( $this->currencies[ $this->currentCurrency ] ) ) ? '<span>'.implode( '</span><span>', $this->currencies[ $this->currentCurrency ] ).'</span>' : $this->currencies[ $this->currentCurrency ]; ?>
			</li>

        <?php }?>

		<?php foreach ($this->currencies as $key => $currency) {?>
			<?php $current = $key == $this->currentCurrency ? 'wcuCurrent' : '';?>

			<?php
			if ( empty( $current ) ) { ?>
				<li class="<?php
				echo $current ?>" data-currency="<?php
				echo $key ?>">
					<?php
					echo ( is_array( $currency ) ) ?  '<span>'.implode( '</span><span>', $currency ).'</span>' : $currency; ?>
				</li>
			<?php
			} ?>

		<?php }?>

        <?php if ( ($layout === "horizontal") && ($side_simple === "right") ) { ?>

            <li class="wcuCurrent" data-currency="<?php echo $this->currentCurrency?>">
                <?php echo $this->currencies[$this->currentCurrency];?>
            </li>

            <li class="wcuCurrencySwitcherSimpleDropdownClose">
                <i class="fa fa-times" aria-hidden="true"></i>
            </li>

        <?php }?>

	</ul>
</div>
