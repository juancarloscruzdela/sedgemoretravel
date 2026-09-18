<?php
/**
 * Template Name: Sedgemore Collective
 * Template Post Type: page
 *
 * @package sadgemore
 */

get_header();

$collective_field = function( $name, $default = '' ) {
	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name );
		if ( null !== $value && '' !== $value && array() !== $value ) {
			return $value;
		}
	}

	return $default;
};

$bring_items = $collective_field(
	'collective_bring_items',
	array(
		array( 'text' => 'Your ambition and drive to build something of your own' ),
		array( 'text' => 'Your expertise and industry knowledge' ),
		array( 'text' => 'Your existing client relationships' ),
		array( 'text' => 'Your network' ),
	)
);
$provide_items = $collective_field(
	'collective_provide_items',
	array(
		array( 'text' => 'More than 20 years of experience in luxury hospitality and travel' ),
		array( 'text' => 'Infrastructure, logistics and operational support' ),
		array( 'text' => 'Contracts and administration' ),
		array( 'text' => 'Guidance and practical expertise at every stage' ),
		array( 'text' => 'The platform to turn your ambition into a running business' ),
	)
);
?>

<main class="collective-page">
	<section class="collective-hero" aria-labelledby="collective-title">
		<div class="collective-container collective-hero__inner">
			<span class="collective-label"><?php echo esc_html( $collective_field( 'collective_hero_label', 'Sedgemore Collective' ) ); ?></span>
			<h1 id="collective-title"><?php echo wp_kses_post( $collective_field( 'collective_hero_title', 'Become an independent travel consultant, with the right team <em>behind you</em>.' ) ); ?></h1>
			<div class="collective-hero__body">
				<p><?php echo esc_html( $collective_field( 'collective_hero_text', 'For commercially driven professionals ready to take their expertise and relationships independent, backed by more than 20 years of industry infrastructure and support.' ) ); ?></p>
				<a class="collective-button" href="#collective-enquire"><?php echo esc_html( $collective_field( 'collective_hero_button', 'Start the conversation' ) ); ?></a>
			</div>
		</div>
	</section>

	<section class="collective-benefits" aria-labelledby="collective-benefits-title">
		<div class="collective-container collective-section">
			<header class="collective-section__heading">
				<span class="collective-label"><?php echo esc_html( $collective_field( 'collective_benefits_label', 'What this means in practice' ) ); ?></span>
				<h2 id="collective-benefits-title"><?php echo wp_kses_post( $collective_field( 'collective_benefits_title', 'You bring the <em>ambition</em>. We do the rest.' ) ); ?></h2>
			</header>
			<div class="collective-benefits__columns">
				<div class="collective-benefits__column">
					<h3><?php echo esc_html( $collective_field( 'collective_bring_label', 'You bring' ) ); ?></h3>
					<ul><?php foreach ( (array) $bring_items as $item ) : ?><?php if ( ! empty( $item['text'] ) ) : ?><li><?php echo esc_html( $item['text'] ); ?></li><?php endif; ?><?php endforeach; ?></ul>
				</div>
				<div class="collective-benefits__column">
					<h3><?php echo esc_html( $collective_field( 'collective_provide_label', 'We provide' ) ); ?></h3>
					<ul><?php foreach ( (array) $provide_items as $item ) : ?><?php if ( ! empty( $item['text'] ) ) : ?><li><?php echo esc_html( $item['text'] ); ?></li><?php endif; ?><?php endforeach; ?></ul>
				</div>
			</div>
		</div>
	</section>

	<section id="collective-enquire" class="collective-enquiry" aria-labelledby="collective-form-title">
		<div class="collective-container collective-section">
			<header class="collective-form__intro">
				<span class="collective-label"><?php echo esc_html( $collective_field( 'collective_form_label', 'Start the conversation' ) ); ?></span>
				<h2 id="collective-form-title"><?php echo wp_kses_post( $collective_field( 'collective_form_title', 'Ready to explore what\'s <em>possible</em>?' ) ); ?></h2>
				<p><?php echo esc_html( $collective_field( 'collective_form_intro', 'Tell us a little about yourself. We will be in touch to arrange a conversation.' ) ); ?></p>
			</header>
			<form id="collective-enquiry-form" class="collective-form" method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
				<input type="hidden" name="action" value="collective_enquiry_form">
				<?php wp_nonce_field( 'collective_enquiry_action', 'collective_nonce' ); ?>
				<div class="collective-form__row">
					<div class="collective-field"><label for="collective-first-name">First name</label><input id="collective-first-name" type="text" name="first_name" autocomplete="given-name" required></div>
					<div class="collective-field"><label for="collective-last-name">Last name</label><input id="collective-last-name" type="text" name="last_name" autocomplete="family-name" required></div>
				</div>
				<div class="collective-field"><label for="collective-email">Email address</label><input id="collective-email" type="email" name="email" autocomplete="email" required></div>
				<div class="collective-field"><label for="collective-background">Current role or background</label><input id="collective-background" type="text" name="background" autocomplete="organization-title" placeholder="e.g. Sales Manager, Account Director" required></div>
				<div class="collective-field"><label for="collective-message">Tell us about yourself</label><textarea id="collective-message" name="message" placeholder="What draws you to independent consulting? What does your experience look like?" required></textarea></div>
				<div id="collective-form-status" class="collective-form__status" role="status" aria-live="polite"></div>
				<button class="collective-button" type="submit"><?php echo esc_html( $collective_field( 'collective_form_button', 'Send enquiry' ) ); ?></button>
			</form>
		</div>
	</section>
</main>

<?php get_footer(); ?>
