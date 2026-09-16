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
?>
<div class="header_nav nav-menu">
	<?php get_template_part( 'template-parts/header_nav_inner' ); ?>
</div>
<?php

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

	$editorial_toc_items        = array();
	$editorial_block_anchor_ids = array();
	$editorial_anchor_counts    = array();

	if ( is_array( $editorial_blocks ) && ! empty( $editorial_blocks ) ) {
		foreach ( $editorial_blocks as $block_index => $block ) {
			if ( ! is_array( $block ) ) {
				continue;
			}

			$type = $block['block_type'] ?? 'movement';

			if ( 'movement' !== $type ) {
				continue;
			}

			$anchor_source = ! empty( $block['label'] ) ? $block['label'] : ( $block['title'] ?? '' );
			$anchor_text   = trim( wp_strip_all_tags( html_entity_decode( (string) $anchor_source, ENT_QUOTES, get_bloginfo( 'charset' ) ) ) );
			$anchor_text = preg_replace( '/\s+/', ' ', $anchor_text );

			if ( ! $anchor_text ) {
				continue;
			}

			$toc_label = strtoupper( $anchor_text ) === $anchor_text ? ucwords( strtolower( $anchor_text ) ) : $anchor_text;

			$anchor_id = sanitize_title( $anchor_text );

			if ( isset( $editorial_anchor_counts[ $anchor_id ] ) ) {
				$editorial_anchor_counts[ $anchor_id ]++;
				$anchor_id .= '-' . $editorial_anchor_counts[ $anchor_id ];
			} else {
				$editorial_anchor_counts[ $anchor_id ] = 1;
			}

			$editorial_block_anchor_ids[ $block_index ] = $anchor_id;
			$editorial_toc_items[] = array(
				'id'    => $anchor_id,
				'label' => $toc_label,
			);
		}
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
		.editorial-article{--warm-white:#FAFAF7;--cream:#F5F2ED;--charcoal:#2A2A27;--dark:#1C1A18;--text:#3A3835;--text-light:#7A7672;background:var(--warm-white);color:var(--text);font-family:'Montserrat',Helvetica,Arial,sans-serif;font-size:15px;line-height:1.85;font-weight:300;text-align:left;-webkit-font-smoothing:antialiased;text-rendering:optimizeLegibility;padding-bottom:96px;position:relative}
		.editorial-article .wrap{max-width:820px;margin:0 auto;padding:0 40px}
		.editorial-article .wrap > * {
			padding-left: 0;
		}
		.editorial-article .col{max-width:660px;margin-left:0;margin-right:auto}
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
		.editorial-article .article-toc{font-family:'Montserrat',Helvetica,Arial,sans-serif}
		.editorial-article .article-toc__toggle{display:none}
		.editorial-article .article-toc__title{display:block;margin-bottom:18px;color:var(--text-light);font-size:10px;font-weight:500;letter-spacing:.42em;text-transform:uppercase}
		.editorial-article .article-toc__track{display:flex;flex-direction:column;gap:13px}
		.editorial-article .article-toc__link{display:block;padding-left:16px;border-left:1px solid transparent;color:var(--text-light);font-size:12px;font-weight:300;letter-spacing:.14em;line-height:1.35;text-decoration:none;transition:border-color .25s ease,color .25s ease}
		.editorial-article .article-toc__link:hover,.editorial-article .article-toc__link.is-active{border-left-color:var(--dark);color:var(--dark)}
		.editorial-article p{margin:0 0 24px;color:var(--text)}
		.editorial-article p:last-child{margin-bottom:0}
		.editorial-article strong{font-weight:500;color:var(--charcoal)}
		.editorial-article .movement .eyebrow{display:block;margin-bottom:16px}
		.editorial-article .movement[id]{scroll-margin-top:132px}
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
		@media (min-width:1180px){.editorial-article .article-toc{position:fixed;top:50%;left:max(34px,calc((100vw - 1180px)/2));z-index:30;width:190px;transform:translateY(-50%);padding:20px 0;pointer-events:auto}.editorial-article .article-toc__track{max-height:calc(100vh - 260px);overflow-y:auto;padding-right:8px}.editorial-article .article-toc__track::-webkit-scrollbar{width:2px}.editorial-article .article-toc__track::-webkit-scrollbar-thumb{background:rgba(42,42,39,.18)}}
		@media (max-width:1179px){.editorial-article .article-toc{position:sticky;top:88px;z-index:30;margin:40px 0 0;background:rgba(250,250,247,.98);border:1px solid rgba(42,42,39,.12);border-radius:28px;box-shadow:0 6px 24px rgba(42,42,39,.08);backdrop-filter:blur(10px);transition:border-radius .2s ease}.editorial-article .article-toc.is-open{border-radius:6px}.editorial-article .article-toc__toggle{display:flex;align-items:center;justify-content:space-between;gap:20px;width:100%;min-height:54px;padding:0 20px;background:transparent;border:0;color:var(--dark);font-family:'Montserrat',Helvetica,Arial,sans-serif;text-align:left;cursor:pointer}.editorial-article .article-toc__toggle-label{min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-size:11px;font-weight:500;letter-spacing:.06em}.editorial-article .article-toc__toggle-prefix{color:var(--text-light);font-size:9px;letter-spacing:.18em;text-transform:uppercase}.editorial-article .article-toc__toggle-text{color:var(--dark)}.editorial-article .article-toc__chevron{flex:0 0 auto;width:8px;height:8px;border-right:1px solid currentColor;border-bottom:1px solid currentColor;transform:rotate(45deg) translateY(-2px);transition:transform .25s ease}.editorial-article .article-toc.is-open .article-toc__chevron{transform:rotate(225deg) translate(-2px,-2px)}.editorial-article .article-toc__title{display:none}.editorial-article .article-toc__track{display:none;max-height:min(52vh,420px);overflow-y:auto;padding:4px 20px 18px;border-top:1px solid rgba(42,42,39,.09)}.editorial-article .article-toc.is-open .article-toc__track{display:flex}.editorial-article .article-toc__link{padding:11px 0 11px 14px;font-size:11px;letter-spacing:.12em}.editorial-article .article-toc__link:first-child{margin-top:5px}}
		@media (max-width:640px){.editorial-article .wrap{padding:0 22px}.editorial-article .hero{padding:80px 0 0}.editorial-article .hero-media{height:clamp(280px,44vh,420px)}.editorial-article .article-toc{top:82px;margin-top:34px}.editorial-article .article-toc__toggle{min-height:52px;padding:0 16px}.editorial-article .article-toc__track{padding-left:16px;padding-right:16px}}
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
				<?php if ( ! empty( $editorial_toc_items ) ) : ?>
					<nav class="article-toc" aria-label="<?php esc_attr_e( 'In this guide', 'sadgemore' ); ?>">
						<button class="article-toc__toggle" type="button" aria-expanded="false" aria-controls="editorial-toc-links">
							<span class="article-toc__toggle-label"><span class="article-toc__toggle-prefix"><?php esc_html_e( 'In this guide:', 'sadgemore' ); ?></span> <span class="article-toc__toggle-text"><?php echo esc_html( $editorial_toc_items[0]['label'] ); ?></span></span>
							<span class="article-toc__chevron" aria-hidden="true"></span>
						</button>
						<span class="article-toc__title"><?php esc_html_e( 'In this guide', 'sadgemore' ); ?></span>
						<div id="editorial-toc-links" class="article-toc__track">
							<?php foreach ( $editorial_toc_items as $toc_index => $toc_item ) : ?>
								<a class="article-toc__link<?php echo 0 === $toc_index ? ' is-active' : ''; ?>" href="#<?php echo esc_attr( $toc_item['id'] ); ?>"><?php echo esc_html( $toc_item['label'] ); ?></a>
							<?php endforeach; ?>
						</div>
					</nav>
				<?php endif; ?>
				<?php if ( is_array( $editorial_blocks ) && ! empty( $editorial_blocks ) ) : ?>
					<div class="rule"></div>
				<?php endif; ?>
			<?php endif; ?>

			<?php if ( is_array( $editorial_blocks ) && ! empty( $editorial_blocks ) ) : ?>
				<?php foreach ( $editorial_blocks as $block_index => $block ) : ?>
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
					$pull_quote     = $block['pull_quote'] ?? '';
					$cta_label  = $block['cta_label'] ?? '';
					$cta_url    = $block['cta_url'] ?? '';
					$is_last_block = array_key_last( $editorial_blocks ) === $block_index;
					?>

					<?php if ( 'rule' === $type ) : ?>
						<div class="rule"></div>
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
						<section class="movement col"<?php echo isset( $editorial_block_anchor_ids[ $block_index ] ) ? ' id="' . esc_attr( $editorial_block_anchor_ids[ $block_index ] ) . '"' : ''; ?>>
							<?php if ( $label ) : ?>
								<span class="label eyebrow"><?php echo esc_html( $label ); ?></span>
							<?php endif; ?>
							<?php if ( $title ) : ?>
								<h2><?php echo wp_kses_post( $title ); ?></h2>
							<?php endif; ?>
							<div class="body">
								<?php echo wp_kses_post( wpautop( $body ) ); ?>
							</div>
						</section>
						<?php if ( $image_url ) : ?>
							<figure class="media col<?php echo $portrait ? ' portrait' : ''; ?>">
								<img class="photo" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $caption ? $caption : $title ) ); ?>">
								<?php if ( $caption ) : ?>
									<figcaption class="credit"><?php echo wp_kses_post( $caption ); ?></figcaption>
								<?php endif; ?>
							</figure>
						<?php endif; ?>
						<?php if ( $pull_quote ) : ?>
							<div class="pull">
								<?php echo wp_kses_post( wpautop( $pull_quote ) ); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
					<?php if ( ! $is_last_block ) : ?>
						<div class="rule"></div>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</article>
	<?php if ( ! empty( $editorial_toc_items ) ) : ?>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				var article = document.querySelector('.editorial-article');
				if (!article) {
					return;
				}

				var tocLinks = Array.prototype.slice.call(article.querySelectorAll('.article-toc__link'));
				if (!tocLinks.length) {
					return;
				}

				var toc = article.querySelector('.article-toc');
				var tocToggle = article.querySelector('.article-toc__toggle');
				var tocToggleText = article.querySelector('.article-toc__toggle-text');

				function closeToc() {
					if (!toc || !tocToggle) {
						return;
					}

					toc.classList.remove('is-open');
					tocToggle.setAttribute('aria-expanded', 'false');
				}

				if (toc && tocToggle) {
					tocToggle.addEventListener('click', function () {
						var willOpen = !toc.classList.contains('is-open');
						toc.classList.toggle('is-open', willOpen);
						tocToggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
					});

					document.addEventListener('click', function (event) {
						if (window.innerWidth < 1180 && toc.classList.contains('is-open') && !toc.contains(event.target)) {
							closeToc();
						}
					});

					document.addEventListener('keydown', function (event) {
						if (event.key === 'Escape' && toc.classList.contains('is-open')) {
							closeToc();
							tocToggle.focus();
						}
					});
				}

				var sections = tocLinks.map(function (link) {
					var id = link.getAttribute('href');
					return id ? document.getElementById(id.slice(1)) : null;
				}).filter(Boolean);

				function setActive(id) {
					tocLinks.forEach(function (link) {
						var isActive = link.getAttribute('href') === '#' + id;
						link.classList.toggle('is-active', isActive);

						if (isActive && tocToggleText) {
							tocToggleText.textContent = link.textContent.trim();
						}
					});
				}

				tocLinks.forEach(function (link) {
					link.addEventListener('click', function (event) {
						var id = link.getAttribute('href');
						var target = id ? document.getElementById(id.slice(1)) : null;

						if (!target) {
							return;
						}

						event.preventDefault();
						var headerOffset = window.innerWidth < 1180 ? 134 : 116;
						var targetTop = target.getBoundingClientRect().top + window.pageYOffset - headerOffset;
						window.scrollTo({ top: targetTop, behavior: 'smooth' });
						setActive(target.id);
						closeToc();
					});
				});

				if ('IntersectionObserver' in window) {
					var observer = new IntersectionObserver(function (entries) {
						entries.forEach(function (entry) {
							if (entry.isIntersecting) {
								setActive(entry.target.id);
							}
						});
					}, {
						rootMargin: '-36% 0px -54% 0px',
						threshold: 0
					});

					sections.forEach(function (section) {
						observer.observe(section);
					});
				}
			});
		</script>
	<?php endif; ?>

<?php
endwhile;

get_footer();
