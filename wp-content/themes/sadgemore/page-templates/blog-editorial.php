<?php
/**
 * Template Name: Blog Editorial Article
 * Template Post Type: post, page
 *
 * Long-form editorial blog template based on the Winter Sun reference layout.
 *
 * @package sadgemore
 */

if ( ! function_exists( 'sedgemore_editorial_asset_url' ) ) {
	function sedgemore_editorial_asset_url( $value, $size = 'full' ) {
		if ( empty( $value ) ) {
			return '';
		}

		if ( is_string( $value ) ) {
			return esc_url_raw( $value );
		}

		if ( is_numeric( $value ) ) {
			$url = wp_get_attachment_image_url( (int) $value, $size );
			return $url ? esc_url_raw( $url ) : '';
		}

		if ( is_array( $value ) ) {
			if ( ! empty( $value['url'] ) ) {
				return esc_url_raw( $value['url'] );
			}

			if ( ! empty( $value['ID'] ) ) {
				$url = wp_get_attachment_image_url( (int) $value['ID'], $size );
				return $url ? esc_url_raw( $url ) : '';
			}
		}

		if ( $value instanceof WP_Post ) {
			$url = wp_get_attachment_image_url( (int) $value->ID, $size );
			return $url ? esc_url_raw( $url ) : '';
		}

		return '';
	}
}

get_header();

while ( have_posts() ) :
	the_post();

	$editorial_label       = function_exists( 'get_field' ) ? (string) get_field( 'editorial_label' ) : '';
	$editorial_title       = function_exists( 'get_field' ) ? (string) get_field( 'editorial_title' ) : '';
	$editorial_standfirst  = function_exists( 'get_field' ) ? (string) get_field( 'editorial_standfirst' ) : '';
	$editorial_byline      = function_exists( 'get_field' ) ? (string) get_field( 'editorial_byline' ) : '';
	$editorial_hero_image  = function_exists( 'get_field' ) ? get_field( 'editorial_hero_image' ) : '';
	$editorial_hero_credit = function_exists( 'get_field' ) ? (string) get_field( 'editorial_hero_credit' ) : '';
	$editorial_intro       = function_exists( 'get_field' ) ? (string) get_field( 'editorial_intro' ) : '';
	$editorial_blocks      = function_exists( 'get_field' ) ? get_field( 'editorial_blocks' ) : array();

	if ( ! $editorial_label ) {
		$terms = get_the_terms( get_the_ID(), 'category' );
		$editorial_label = ( $terms && ! is_wp_error( $terms ) ) ? implode( ' &middot; ', wp_list_pluck( $terms, 'name' ) ) : get_bloginfo( 'name' );
	}

	if ( ! $editorial_title ) {
		$editorial_title = get_the_title();
	}

	if ( ! $editorial_standfirst ) {
		$editorial_standfirst = has_excerpt() ? get_the_excerpt() : '';
	}

	if ( ! $editorial_byline ) {
		$editorial_byline = get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) );
	}

	if ( ! $editorial_hero_image ) {
		$editorial_hero_image = get_post_thumbnail_id();
	}

	if ( ! $editorial_intro ) {
		$editorial_intro = get_the_content( null, false );
	}

	$hero_image_url = sedgemore_editorial_asset_url( $editorial_hero_image, 'full' );
	?>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">

	<style>
		.editorial-article,
		.editorial-article *,
		.editorial-article *::before,
		.editorial-article *::after{box-sizing:border-box}
		.editorial-article{--warm-white:#FAFAF7;--cream:#F5F2ED;--charcoal:#2A2A27;--dark:#1C1A18;--text:#3A3835;--text-light:#7A7672;background:var(--warm-white);color:var(--text);font-family:'Montserrat',Helvetica,Arial,sans-serif;font-size:15px;line-height:1.85;font-weight:300;text-align:left;-webkit-font-smoothing:antialiased;text-rendering:optimizeLegibility}
		.editorial-article .wrap{max-width:820px;margin:0 auto;padding:0 40px}
		.editorial-article .col{max-width:660px}
		.editorial-article .label{font-family:'Montserrat',Helvetica,Arial,sans-serif;font-size:11px;text-transform:uppercase;letter-spacing:.35em;font-weight:500;color:var(--text-light)}
		.editorial-article .hero{padding:80px 0 0}
		.editorial-article .hero .label{display:block;margin-bottom:26px}
		.editorial-article h1{font-family:'Cormorant Garamond',Georgia,serif;font-weight:400;font-size:clamp(32px,4.3vw,47px);line-height:1.18;color:var(--dark);max-width:640px;text-wrap:balance;margin:0}
		.editorial-article h1 em,.editorial-article h1 i{font-style:italic;font-weight:400}
		.editorial-article .standfirst{max-width:520px;margin:26px 0 0;font-size:15px;line-height:1.85;color:var(--text);font-weight:300}
		.editorial-article .byline{margin-top:30px;font-size:11px;letter-spacing:.2em;text-transform:uppercase;color:var(--text-light)}
		.editorial-article figure{margin:46px 0 0}
		.editorial-article figure.media{display:block}
		.editorial-article figure.media img.photo{width:100%;height:auto;display:block;border:1px solid #E5DFD6}
		.editorial-article figure.portrait{max-width:560px}
		.editorial-article .hero-fig{margin:46px 0 0}
		.editorial-article .hero-media{width:100%;height:clamp(360px,52vh,560px);object-fit:cover;object-position:50% 52%;display:block;border:1px solid #E5DFD6}
		.editorial-article figcaption.credit{margin-top:11px;font-size:11px;letter-spacing:.05em;color:var(--text-light)}
		.editorial-article figcaption.credit em,.editorial-article figcaption.credit i{font-family:'Cormorant Garamond',Georgia,serif;font-style:italic;font-size:13px;color:var(--charcoal)}
		.editorial-article .intro{padding-top:52px}
		.editorial-article p{margin:0 0 24px;color:var(--text)}
		.editorial-article p:last-child{margin-bottom:0}
		.editorial-article strong{font-weight:500;color:var(--charcoal)}
		.editorial-article .movement .eyebrow{display:block;margin-bottom:16px}
		.editorial-article .movement h2{font-family:'Cormorant Garamond',Georgia,serif;font-weight:400;font-size:clamp(26px,3.2vw,35px);line-height:1.16;color:var(--dark);margin:0 0 24px;max-width:22ch}
		.editorial-article .movement h2 em,.editorial-article .movement h2 i{font-style:italic}
		.editorial-article .movement .body,.editorial-article .movement .body *{margin-left:0!important;padding-left:0!important}
		.editorial-article .rule{width:100%;margin:56px 0;height:1px;background:rgba(42,42,39,.13)}
		.editorial-article .rule.short{width:56px;margin:52px 0;background:rgba(42,42,39,.32)}
		.editorial-article .pull{margin:52px 0;padding-left:26px;border-left:1px solid rgba(42,42,39,.28);max-width:600px}
		.editorial-article .pull p{font-family:'Cormorant Garamond',Georgia,serif;font-style:italic;font-weight:300;font-size:clamp(21px,2.9vw,27px);line-height:1.36;color:var(--charcoal);margin:0}
		.editorial-article .aside .label{display:block;margin-bottom:16px}
		.editorial-article .aside h3{font-family:'Cormorant Garamond',Georgia,serif;font-weight:400;font-size:24px;color:var(--dark);margin:0 0 14px}
		.editorial-article .aside h3 em,.editorial-article .aside h3 i{font-style:italic}
		.editorial-article .closing .label{display:block;margin-bottom:20px}
		.editorial-article .closing h2{font-family:'Cormorant Garamond',Georgia,serif;font-weight:400;font-size:clamp(28px,3.6vw,40px);line-height:1.18;color:var(--dark);max-width:18ch;margin:0 0 22px}
		.editorial-article .closing h2 em,.editorial-article .closing h2 i{font-style:italic}
		.editorial-article .closing p{max-width:520px;margin-bottom:34px;color:var(--text)}
		.editorial-article .cta{display:inline-block;background:var(--dark);color:var(--warm-white);font-family:'Montserrat',Helvetica,Arial,sans-serif;font-size:12px;font-weight:500;letter-spacing:.22em;text-transform:uppercase;text-decoration:none;padding:17px 42px;border:1px solid var(--dark);transition:background .3s ease,color .3s ease}
		.editorial-article .cta:hover{background:var(--warm-white);color:var(--dark)}
		.editorial-article .credits{padding:0 0 8px}
		.editorial-article .credits .label{display:block;margin-bottom:14px}
		.editorial-article .credits p{font-size:12px;line-height:1.75;color:var(--text-light);max-width:640px}
		.editorial-article .tail{padding:72px 0 0}
		.editorial-article .foot{padding:56px 0 96px}
		@media (max-width:640px){.editorial-article .wrap{padding:0 22px}.editorial-article .hero{padding:56px 0 0}.editorial-article .hero-media{height:clamp(280px,44vh,420px)}}
	</style>

	<article class="editorial-article">
		<div class="wrap">
			<header class="hero col">
				<span class="label"><?php echo wp_kses_post( $editorial_label ); ?></span>
				<h1><?php echo wp_kses_post( $editorial_title ); ?></h1>
				<?php if ( $editorial_standfirst ) : ?>
					<p class="standfirst"><?php echo esc_html( $editorial_standfirst ); ?></p>
				<?php endif; ?>
				<?php if ( $editorial_byline ) : ?>
					<div class="byline"><span><?php echo esc_html( $editorial_byline ); ?></span></div>
				<?php endif; ?>
			</header>

			<?php if ( $hero_image_url ) : ?>
				<figure class="hero-fig">
					<img class="hero-media" src="<?php echo esc_url( $hero_image_url ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $editorial_title ) ); ?>">
					<?php if ( $editorial_hero_credit ) : ?>
						<figcaption class="credit"><?php echo wp_kses_post( $editorial_hero_credit ); ?></figcaption>
					<?php endif; ?>
				</figure>
			<?php endif; ?>

			<?php if ( $editorial_intro ) : ?>
				<div class="intro col">
					<?php echo wp_kses_post( wpautop( $editorial_intro ) ); ?>
				</div>
			<?php endif; ?>

			<?php if ( is_array( $editorial_blocks ) && ! empty( $editorial_blocks ) ) : ?>
				<?php foreach ( $editorial_blocks as $block ) : ?>
					<?php
					if ( ! is_array( $block ) ) {
						continue;
					}

					$type       = $block['block_type'] ?? 'movement';
					$label      = $block['label'] ?? '';
					$title      = $block['title'] ?? '';
					$body       = $block['body'] ?? '';
					$image      = $block['image'] ?? '';
					$image_url  = sedgemore_editorial_asset_url( $image, 'full' );
					$caption    = $block['caption'] ?? '';
					$portrait   = ! empty( $block['portrait_image'] );
					$short_rule = ! empty( $block['short_rule'] );
					$divider_before = ! empty( $block['divider_before'] );
					$divider_after  = ! empty( $block['divider_after'] );
					$pull_quote     = $block['pull_quote'] ?? '';
					$cta_label  = $block['cta_label'] ?? '';
					$cta_url    = $block['cta_url'] ?? '';
					?>

					<?php if ( 'rule' === $type ) : ?>
						<div class="rule<?php echo $short_rule ? ' short' : ''; ?>"></div>
					<?php elseif ( 'image' === $type && $image_url ) : ?>
						<figure class="media col<?php echo $portrait ? ' portrait' : ''; ?>">
							<img class="photo" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $caption ? $caption : $title ) ); ?>">
							<?php if ( $caption ) : ?>
								<figcaption class="credit"><?php echo wp_kses_post( $caption ); ?></figcaption>
							<?php endif; ?>
						</figure>
					<?php elseif ( 'pull' === $type && $body ) : ?>
						<div class="pull">
							<?php echo wp_kses_post( wpautop( $body ) ); ?>
						</div>
					<?php elseif ( 'aside' === $type ) : ?>
						<section class="aside col">
							<?php if ( $label ) : ?>
								<span class="label"><?php echo esc_html( $label ); ?></span>
							<?php endif; ?>
							<?php if ( $title ) : ?>
								<h3><?php echo wp_kses_post( $title ); ?></h3>
							<?php endif; ?>
							<?php echo wp_kses_post( wpautop( $body ) ); ?>
						</section>
					<?php elseif ( 'closing' === $type ) : ?>
						<section class="closing col tail">
							<?php if ( $label ) : ?>
								<span class="label"><?php echo esc_html( $label ); ?></span>
							<?php endif; ?>
							<?php if ( $title ) : ?>
								<h2><?php echo wp_kses_post( $title ); ?></h2>
							<?php endif; ?>
							<?php echo wp_kses_post( wpautop( $body ) ); ?>
							<?php if ( $cta_label && $cta_url ) : ?>
								<a class="cta" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_label ); ?></a>
							<?php endif; ?>
						</section>
					<?php elseif ( 'credits' === $type ) : ?>
						<section class="credits col foot">
							<?php if ( $label ) : ?>
								<span class="label"><?php echo esc_html( $label ); ?></span>
							<?php endif; ?>
							<?php echo wp_kses_post( wpautop( $body ) ); ?>
						</section>
					<?php else : ?>
						<?php if ( $divider_before ) : ?>
							<div class="rule<?php echo $short_rule ? ' short' : ''; ?>"></div>
						<?php endif; ?>
						<section class="movement col">
							<?php if ( $label ) : ?>
								<span class="label eyebrow"><?php echo esc_html( $label ); ?></span>
							<?php endif; ?>
							<?php if ( $title ) : ?>
								<h2><?php echo wp_kses_post( $title ); ?></h2>
							<?php endif; ?>
							<div class="body">
								<?php echo wp_kses_post( wpautop( $body ) ); ?>
							</div>
							<?php if ( $pull_quote ) : ?>
								<div class="pull">
									<?php echo wp_kses_post( wpautop( $pull_quote ) ); ?>
								</div>
							<?php endif; ?>
						</section>
						<?php if ( $image_url ) : ?>
							<figure class="media col<?php echo $portrait ? ' portrait' : ''; ?>">
								<img class="photo" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $caption ? $caption : $title ) ); ?>">
								<?php if ( $caption ) : ?>
									<figcaption class="credit"><?php echo wp_kses_post( $caption ); ?></figcaption>
								<?php endif; ?>
							</figure>
						<?php endif; ?>
						<?php if ( $divider_after ) : ?>
							<div class="rule<?php echo $short_rule ? ' short' : ''; ?>"></div>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</article>

<?php
endwhile;

get_footer();
