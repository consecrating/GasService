<?php
/**
 * Plugin Name:  KGS — NAVYA Corporate Lead Magnet Slider
 * Description:  Corporate-style lead magnet slider promoting the NAVYA 10 KG Composite FTL campaign. Renders on the front page and via the [kgs_navya_slider] shortcode. Self-contained: no external CSS/JS, no database writes.
 * Version:      1.0.0
 * Author:       Sanctify
 * License:      GPL-2.0-or-later
 *
 * Placement is controlled by KGS_NAVYA_SLIDER_POSITION (optionally defined in wp-config.php):
 *   'after:3'  (default) inject after the 3rd top-level Elementor section on the front page
 *   'top'                prepend to front page content
 *   'bottom'             append to front page content
 *   'shortcode'          do not auto-inject; only render where [kgs_navya_slider] is used
 *
 * To disable entirely: define('KGS_NAVYA_SLIDER_DISABLE', true); in wp-config.php,
 * or delete this file from wp-content/mu-plugins/.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'KGS_NAVYA_SLIDER_DISABLE' ) && KGS_NAVYA_SLIDER_DISABLE ) {
	return;
}

if ( ! class_exists( 'KGS_Navya_Lead_Slider' ) ) :

	final class KGS_Navya_Lead_Slider {

		const VERSION  = '1.0.0';
		const SHORTCODE = 'kgs_navya_slider';

		/** Campaign constants — single source of truth for rates/links. */
		const WHATSAPP   = '919923881403';
		const PHONE_HUMAN = '+91 99238 81403';
		const CAMPAIGN_URL = 'https://www.kavlekargasservice.in/navya-campaign/';
		const RATE_FTL    = '4,878.50';
		const RATE_REFILL = '1,677.00';
		const RATE_WEF    = '01.09.2026';

		/** @var bool Guard so assets print only once per request. */
		private static $assets_done = false;

		/** @var bool Guard so auto-injection happens only once per request. */
		private static $injected = false;

		public static function init() {
			add_shortcode( self::SHORTCODE, array( __CLASS__, 'shortcode' ) );
			add_filter( 'the_content', array( __CLASS__, 'maybe_inject' ), 20 );
		}

		/** Resolved placement mode. */
		private static function position() {
			$pos = defined( 'KGS_NAVYA_SLIDER_POSITION' ) ? KGS_NAVYA_SLIDER_POSITION : 'after:3';
			return is_string( $pos ) ? trim( $pos ) : 'after:3';
		}

		public static function shortcode() {
			return self::render();
		}

		/**
		 * Append/prepend the block to the front page content.
		 * Deliberately narrow: main query, in the loop, front page, not admin/feed/REST.
		 */
		public static function maybe_inject( $content ) {
			if ( self::$injected || is_admin() || is_feed() ) {
				return $content;
			}
			if ( ! is_front_page() || ! is_main_query() || ! in_the_loop() ) {
				return $content;
			}
			if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
				return $content;
			}
			// Let Elementor's own editor/preview render untouched.
			if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
				return $content;
			}

			$pos = self::position();
			if ( 'shortcode' === $pos ) {
				return $content;
			}
			// If the shortcode is already present, respect it and skip auto-injection.
			if ( has_shortcode( $content, self::SHORTCODE ) ) {
				return $content;
			}

			self::$injected = true;

			if ( 'top' === $pos ) {
				return self::render() . $content;
			}
			// 'bottom' and 'after:N' both render after the content; 'after:N' is
			// then relocated client-side (see relocation script in render()).
			return $content . self::render();
		}

		/** Section index for 'after:N', or 0 when not applicable. */
		private static function relocate_index() {
			$pos = self::position();
			if ( 0 === strpos( $pos, 'after:' ) ) {
				return max( 0, (int) substr( $pos, 6 ) );
			}
			return 0;
		}

		public static function render() {
			$out = '';
			if ( ! self::$assets_done ) {
				self::$assets_done = true;
				$out .= self::css();
			}
			$out .= self::html();
			$out .= self::js();
			return $out;
		}

		/** WhatsApp deep link with a pre-filled enquiry message. */
		private static function wa_link( $message ) {
			return 'https://wa.me/' . self::WHATSAPP . '?text=' . rawurlencode( $message );
		}

		private static function icon( $name ) {
			$icons = array(
				'check'  => '<path d="M20 6 9 17l-5-5"/>',
				'bolt'   => '<path d="M13 2 3 14h8l-1 8 10-12h-8l1-8z"/>',
				'truck'  => '<path d="M1 3h13v13H1zM14 8h4l3 3v5h-7"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="17.5" cy="18.5" r="2.5"/>',
				'id'     => '<rect x="2" y="4" width="20" height="16" rx="2"/><circle cx="9" cy="10" r="2.5"/><path d="M14 9h5M14 13h5M5 16c1-2 6-2 7 0"/>',
				'wallet' => '<path d="M3 6h16a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a1 1 0 0 1-1-1z"/><path d="M3 6a2 2 0 0 1 2-2h11"/><circle cx="17" cy="12.5" r="1.3"/>',
				'shield' => '<path d="M12 2 4 5v7c0 5 3.5 8.5 8 10 4.5-1.5 8-5 8-10V5z"/><path d="m9 12 2 2 4-4"/>',
				'feather' => '<path d="M20 4a6 6 0 0 0-8 0l-8 8 4 4 8-8a6 6 0 0 0 4-4z"/><path d="M4 20 12 12"/>',
				'gem'    => '<path d="M6 3h12l4 6-10 12L2 9z"/><path d="M2 9h20M12 3 8 9l4 12 4-12-4-6z"/>',
				'expand' => '<path d="M15 3h6v6M9 21H3v-6M21 3l-7 7M3 21l7-7"/>',
				'rotate' => '<path d="M21 12a9 9 0 1 1-3-6.7"/><path d="M21 3v6h-6"/>',
				'phone'  => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2z"/>',
				'whatsapp' => '<path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.32 4.96L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91C21.96 6.45 17.5 2 12.04 2zm5.8 14.1c-.25.7-1.45 1.33-2 1.37-.55.05-1.06.25-3.58-.74-3.03-1.19-4.95-4.33-5.1-4.53-.15-.2-1.2-1.6-1.2-3.05s.76-2.16 1.03-2.46c.27-.3.58-.37.78-.37h.56c.18 0 .42-.07.65.5.25.6.84 2.05.91 2.2.07.15.12.32.02.52-.1.2-.15.32-.3.5l-.45.5c-.15.15-.3.31-.13.61.17.3.77 1.27 1.65 2.06 1.13 1.01 2.08 1.32 2.38 1.47.3.15.47.13.65-.08.17-.2.75-.87.95-1.17.2-.3.4-.25.67-.15.27.1 1.72.81 2.02.96.3.15.5.22.57.35.08.12.08.72-.17 1.42z"/>',
				'arrow'  => '<path d="M5 12h14M13 6l6 6-6 6"/>',
				'chev-l' => '<path d="M15 18l-6-6 6-6"/>',
				'chev-r' => '<path d="M9 6l6 6-6 6"/>',
				'star'   => '<path d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8-6.2-3.3-6.2 3.3L7 14.2l-5-4.9 6.9-1z"/>',
			);
			$fill = in_array( $name, array( 'whatsapp', 'star' ), true ) ? 'currentColor' : 'none';
			$path = isset( $icons[ $name ] ) ? $icons[ $name ] : '';
			return '<svg class="kgsnls-i" viewBox="0 0 24 24" fill="' . $fill . '" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $path . '</svg>';
		}

		/** ------------------------------------------------------------------ CSS */
		private static function css() {
			$css = <<<CSS
.kgsnls{--kgs-blue:#1e3a8a;--kgs-blue-d:#132b66;--kgs-blue-2:#00378e;--kgs-red:#d9121f;--kgs-red-d:#b30f1a;--kgs-gold:#efba1c;--kgs-mint:#e8f5e9;--kgs-mint-2:#a5d6a7;--kgs-ink:#1d1f2e;--kgs-muted:#5b6478;--kgs-line:#e4e8f0;--kgs-r:16px;--kgs-r-lg:22px;position:relative;box-sizing:border-box;margin:0;padding:clamp(34px,4vw,54px) 0;background:linear-gradient(135deg,var(--kgs-blue-d) 0%,var(--kgs-blue) 52%,var(--kgs-blue-2) 100%);font-family:'Jost','Montserrat',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;line-height:1.55;color:#fff;overflow:hidden;isolation:isolate;-webkit-font-smoothing:antialiased}
.kgsnls *,.kgsnls *::before,.kgsnls *::after{box-sizing:border-box}
/* the host theme sets list-style on li and zeroes bare svg widths; these scoped
   resets make the component immune to both */
.kgsnls ul,.kgsnls ol{list-style:none!important;margin:0;padding:0}
.kgsnls li{list-style:none!important;display:block;margin:0;padding:0;background:none;text-indent:0}
.kgsnls li::marker{content:""}
.kgsnls li::before{content:none!important;display:none!important}
.kgsnls .kgsnls-i{--kgs-is:16px;width:var(--kgs-is)!important;height:var(--kgs-is)!important;min-width:var(--kgs-is);flex:0 0 auto;display:inline-block;vertical-align:middle;max-width:none}
.kgsnls::before{content:"";position:absolute;inset:0 0 auto;height:3px;background:linear-gradient(90deg,var(--kgs-gold),var(--kgs-red) 45%,var(--kgs-mint-2));z-index:3}
.kgsnls::after{content:"";position:absolute;width:640px;height:640px;right:-190px;top:-230px;background:radial-gradient(circle,rgba(239,186,28,.16),transparent 66%);border-radius:50%;pointer-events:none;z-index:0}
.kgsnls-glow{position:absolute;width:560px;height:560px;left:-200px;bottom:-260px;background:radial-gradient(circle,rgba(217,18,31,.20),transparent 68%);border-radius:50%;pointer-events:none;z-index:0}
.kgsnls-wrap{position:relative;z-index:2;width:100%;max-width:1200px;margin:0 auto;padding:0 22px}
.kgsnls-head{text-align:center;max-width:800px;margin:0 auto clamp(24px,2.6vw,34px)}
/* margins carry !important because the host post-content wrapper zeroes/overrides
   paragraph margins; the eyebrow selector is also scoped so the subtext rule below
   can't clobber its bottom margin (they are both <p> inside .kgsnls-head) */
.kgsnls-eyebrow{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.22);color:var(--kgs-mint);font-size:.76rem;font-weight:600;letter-spacing:1.4px;text-transform:uppercase;padding:8px 16px;border-radius:50px;margin:0 0 20px!important}
.kgsnls-eyebrow .kgsnls-i{--kgs-is:15px;color:var(--kgs-gold)}
.kgsnls-head h2{margin:0!important;color:#fff;font-family:'Jost','Montserrat',sans-serif;font-size:clamp(1.7rem,3.2vw,2.5rem);font-weight:700;line-height:1.14;letter-spacing:-.5px}
.kgsnls-head h2 em{font-style:normal;color:var(--kgs-gold)}
.kgsnls-head p:not(.kgsnls-eyebrow){margin:16px auto 0!important;max-width:62ch;color:rgba(255,255,255,.82);font-size:clamp(1rem,1.35vw,1.12rem);line-height:1.5}
.kgsnls-grid{display:grid;grid-template-columns:minmax(0,1.28fr) minmax(0,1fr);gap:clamp(18px,2.2vw,28px);align-items:center}

/* ---- slider shell ---- */
.kgsnls-slider{position:relative;min-width:0;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);border-radius:var(--kgs-r-lg);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px);display:flex;flex-direction:column;overflow:hidden}
/* stable min-height smooths the small height differences between slides so the card
   doesn't resize as you navigate; slides center their content within it */
.kgsnls-viewport{position:relative;flex:1 1 auto;overflow:hidden;display:flex;flex-direction:column;min-height:clamp(300px,30vw,360px)}
/* track fills the viewport so slides stretch to full height and their trailing element anchors to the bottom */
.kgsnls-track{flex:1 1 auto;display:flex;align-items:stretch;transition:transform .55s cubic-bezier(.4,0,.2,1);will-change:transform}
/* content is vertically centered within the viewport, so slides read as a tidy block
   rather than clumping at the top with a void beneath */
.kgsnls-slide{flex:0 0 100%;width:100%;min-width:0;padding:clamp(26px,2.8vw,40px);display:flex;flex-direction:column;justify-content:center}
/* trailing CTA/footnote separated from the content by a hairline divider */
.kgsnls-slide>.kgsnls-sc{padding-top:20px;border-top:1px solid rgba(255,255,255,.12)}
.kgsnls-badge{display:inline-flex;align-self:flex-start;align-items:center;gap:7px;background:var(--kgs-gold);color:#3a2a00;font-size:.72rem;font-weight:700;letter-spacing:1.1px;text-transform:uppercase;padding:7px 15px;border-radius:50px;margin-bottom:16px}
.kgsnls-badge.is-red{background:var(--kgs-red);color:#fff}
.kgsnls-badge .kgsnls-i{--kgs-is:13px}
.kgsnls-slide h3{margin:0 0 12px;color:#fff;font-family:'Jost','Montserrat',sans-serif;font-size:clamp(1.45rem,2.6vw,2.05rem);font-weight:700;line-height:1.14;letter-spacing:-.5px}
.kgsnls-slide h3 span{color:var(--kgs-gold)}
.kgsnls-slide>p{margin:0;color:rgba(255,255,255,.82);font-size:clamp(.98rem,1.3vw,1.08rem);line-height:1.55;max-width:52ch}
.kgsnls-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin:22px 0;padding:0;list-style:none}
.kgsnls-stats li{background:linear-gradient(150deg,rgba(255,255,255,.12),rgba(255,255,255,.05));border:1px solid rgba(255,255,255,.16);border-radius:var(--kgs-r);padding:18px 16px;text-align:center}
.kgsnls-stats b{display:block;font-family:'Anton','Jost',sans-serif;font-size:2rem;font-weight:400;letter-spacing:.5px;color:#fff;line-height:1}
.kgsnls-stats b i{font-style:normal;font-size:.82rem;color:var(--kgs-mint-2);margin-left:3px;letter-spacing:.5px}
.kgsnls-stats small{display:block;margin-top:8px;font-size:.78rem;font-weight:500;text-transform:uppercase;letter-spacing:.6px;color:rgba(255,255,255,.72)}
.kgsnls-list{margin:20px 0 0;padding:0;list-style:none;display:grid;gap:11px}
.kgsnls-list li{display:flex;gap:11px;align-items:flex-start;font-size:.93rem;color:rgba(255,255,255,.86)}
.kgsnls-list .kgsnls-ic{flex:0 0 auto;--kgs-is:26px;border-radius:8px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);display:flex;align-items:center;justify-content:center;color:var(--kgs-mint-2)}
.kgsnls-list .kgsnls-i{--kgs-is:14px}
.kgsnls-list strong{display:block;color:#fff;font-weight:600}
.kgsnls-list small{display:block;color:rgba(255,255,255,.62);font-size:.8rem;margin-top:1px}

/* price slide */
.kgsnls-rates{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px;margin:20px 0 0}
.kgsnls-rate{background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.16);border-radius:var(--kgs-r);padding:15px 16px}
.kgsnls-rate.is-lead{background:linear-gradient(140deg,rgba(239,186,28,.20),rgba(255,255,255,.07));border-color:rgba(239,186,28,.42)}
/* flex-start keeps the icon on the label's first line when the text wraps */
.kgsnls-rate span{display:flex;align-items:flex-start;gap:7px;font-size:.72rem;font-weight:600;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.68)}
.kgsnls-rate span .kgsnls-i{--kgs-is:13px;flex:0 0 auto;margin-top:2px;color:var(--kgs-mint-2)}
.kgsnls-rate b{display:block;margin-top:7px;font-family:'Anton','Jost',sans-serif;font-size:clamp(1.5rem,3vw,1.95rem);font-weight:400;letter-spacing:.5px;color:#fff;line-height:1}
.kgsnls-rate b u{text-decoration:none;color:var(--kgs-gold);font-size:.62em;margin-right:2px;vertical-align:baseline}
.kgsnls-rate small{display:block;margin-top:5px;font-size:.74rem;color:rgba(255,255,255,.6)}
.kgsnls-wef{margin:13px 0 0;font-size:.76rem;color:rgba(255,255,255,.58)}

/* benefit chips */
.kgsnls-chips{display:flex;flex-wrap:wrap;gap:9px;margin:20px 0 0;padding:0;list-style:none}
.kgsnls-chips li{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.09);border:1px solid rgba(255,255,255,.16);border-radius:50px;padding:9px 15px;font-size:.85rem;font-weight:500;color:rgba(255,255,255,.9)}
.kgsnls-chips .kgsnls-i{--kgs-is:15px;color:var(--kgs-gold)}

/* slide cta */
.kgsnls-sc{display:flex;flex-wrap:wrap;gap:11px;align-items:center;margin:24px 0 0}
.kgsnls-link{display:inline-flex;align-items:center;gap:8px;color:#fff;font-size:.86rem;font-weight:600;text-decoration:none;border-bottom:1px solid rgba(255,255,255,.34);padding-bottom:2px;transition:border-color .2s,color .2s}
.kgsnls-link .kgsnls-i{--kgs-is:15px;transition:transform .2s}
.kgsnls-link:hover,.kgsnls-link:focus-visible{color:var(--kgs-gold);border-color:var(--kgs-gold)}
.kgsnls-link:hover .kgsnls-i{transform:translateX(3px)}

/* ---- slider controls ---- */
.kgsnls-ctrls{display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;padding:0 clamp(24px,3vw,38px) clamp(20px,2.4vw,26px)}
.kgsnls-dots{display:flex;align-items:center;gap:8px;margin:0;padding:0;list-style:none}
.kgsnls-dot{width:26px!important;height:5px!important;min-width:0!important;min-height:0!important;padding:0!important;margin:0!important;border:0;border-radius:50px;background:rgba(255,255,255,.26);cursor:pointer;transition:background .25s,width .25s}
.kgsnls-dot:hover{background:rgba(255,255,255,.5)}
.kgsnls-dot[aria-current="true"]{width:42px!important;background:var(--kgs-gold)}
.kgsnls-arrows{display:flex;gap:9px}
/* !important guards: the host theme's global button rules otherwise stretch these into ovals */
.kgsnls-arrow{width:40px!important;height:40px!important;min-width:40px!important;max-width:40px!important;min-height:40px!important;flex:0 0 40px;padding:0!important;margin:0!important;display:flex;align-items:center;justify-content:center;border-radius:50%!important;background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.26);color:#fff;cursor:pointer;line-height:1;transition:background .2s,border-color .2s,transform .2s}
.kgsnls-arrow:hover{background:rgba(255,255,255,.2);border-color:#fff;transform:translateY(-1px)}
.kgsnls-arrow .kgsnls-i{--kgs-is:18px}
.kgsnls-progress{position:relative;height:3px;background:rgba(255,255,255,.14);overflow:hidden;flex:0 0 auto}
.kgsnls-progress i{display:block;height:100%;width:100%;background:linear-gradient(90deg,var(--kgs-gold),var(--kgs-mint-2));transform-origin:0 50%;transform:scaleX(0)}
.kgsnls.is-playing .kgsnls-progress i{animation:kgsnls-bar var(--kgs-dur,7000ms) linear forwards}
@keyframes kgsnls-bar{from{transform:scaleX(0)}to{transform:scaleX(1)}}

/* ---- lead form ---- */
.kgsnls-form{position:relative;min-width:0;background:#fff;border-radius:var(--kgs-r-lg);padding:clamp(22px,2.6vw,32px);color:var(--kgs-ink);box-shadow:0 30px 60px -22px rgba(6,14,40,.6);display:flex;flex-direction:column}
.kgsnls-form-top{display:flex;align-items:flex-start;gap:12px;margin-bottom:6px}
.kgsnls-form-ic{flex:0 0 42px;width:42px;height:42px;border-radius:12px;background:linear-gradient(140deg,var(--kgs-red),#ff5a4d);display:flex;align-items:center;justify-content:center;color:#fff;box-shadow:0 8px 18px -7px rgba(217,18,31,.65)}
.kgsnls-form-ic .kgsnls-i{--kgs-is:20px}
.kgsnls-form h3{margin:0;font-family:'Jost','Montserrat',sans-serif;font-size:1.35rem;font-weight:700;color:var(--kgs-ink);line-height:1.22;letter-spacing:-.3px}
.kgsnls-form-top p{margin:4px 0 0;font-size:.85rem;color:var(--kgs-muted)}
.kgsnls-offer{display:flex;align-items:center;gap:9px;background:var(--kgs-mint);border:1px solid #c8e6c9;border-radius:12px;padding:10px 13px;margin:14px 0 16px;font-size:.82rem;font-weight:600;color:#1b5e20}
.kgsnls-offer .kgsnls-i{--kgs-is:16px;flex:0 0 auto;color:#2e7d32}
.kgsnls-fg{margin-bottom:14px}
.kgsnls-fg label{display:block;font-size:.78rem;font-weight:600;letter-spacing:.3px;text-transform:uppercase;color:var(--kgs-muted);margin-bottom:7px}
.kgsnls-fg label .kgsnls-req{color:var(--kgs-red)}
.kgsnls-fw{position:relative;display:flex;align-items:center}
.kgsnls-fw>.kgsnls-i{position:absolute;left:14px;--kgs-is:17px;color:#97a1b5;pointer-events:none}
.kgsnls-fw .kgsnls-pre{position:absolute;left:38px;font-size:.95rem;font-weight:600;color:var(--kgs-muted);pointer-events:none}
.kgsnls input[type=text],.kgsnls input[type=tel]{width:100%;font-family:inherit;font-size:1rem;color:var(--kgs-ink);background:#f7f9fc;border:1.5px solid var(--kgs-line);border-radius:12px;padding:13px 15px 13px 40px;transition:border-color .2s,background .2s,box-shadow .2s;-webkit-appearance:none;appearance:none}
.kgsnls input.kgsnls-has-pre{padding-left:76px}
.kgsnls input::placeholder{color:#a8b1c2}
.kgsnls input:focus{outline:none;background:#fff;border-color:var(--kgs-blue);box-shadow:0 0 0 3px rgba(30,58,138,.13)}
.kgsnls input[aria-invalid=true]{border-color:var(--kgs-red);background:#fff5f5}
.kgsnls-err{display:none;margin-top:5px;font-size:.75rem;font-weight:500;color:var(--kgs-red)}
.kgsnls-err.is-on{display:block}
.kgsnls-hp{position:absolute!important;left:-9999px!important;width:1px!important;height:1px!important;overflow:hidden}
.kgsnls-submit{width:100%;display:inline-flex;align-items:center;justify-content:center;gap:9px;font-family:inherit;font-size:.96rem;font-weight:600;color:#fff;background:var(--kgs-red);border:0;border-radius:50px;padding:14px 22px;margin-top:4px;cursor:pointer;transition:background .2s,transform .2s,box-shadow .2s;box-shadow:0 12px 24px -10px rgba(217,18,31,.7)}
.kgsnls-submit:hover{background:var(--kgs-red-d);transform:translateY(-2px);box-shadow:0 16px 30px -10px rgba(217,18,31,.75)}
.kgsnls-submit .kgsnls-i{--kgs-is:18px}
.kgsnls-alt{display:flex;align-items:center;justify-content:center;gap:8px;margin:12px 0 0;font-size:.84rem;color:var(--kgs-muted)}
.kgsnls-alt a{display:inline-flex;align-items:center;gap:6px;color:var(--kgs-blue);font-weight:600;text-decoration:none;border-bottom:1px solid rgba(30,58,138,.3)}
.kgsnls-alt a:hover{color:var(--kgs-red);border-color:var(--kgs-red)}
.kgsnls-alt .kgsnls-i{--kgs-is:14px}
.kgsnls-trust{display:flex;flex-wrap:wrap;gap:6px 14px;margin:16px 0 0;padding:14px 0 0;border-top:1px solid var(--kgs-line);list-style:none}
.kgsnls-trust li{display:inline-flex;align-items:center;gap:6px;font-size:.74rem;font-weight:500;color:var(--kgs-muted)}
.kgsnls-trust .kgsnls-i{--kgs-is:13px;color:#2e7d32}
.kgsnls-note{margin:11px 0 0;font-size:.7rem;line-height:1.5;color:#8b94a6}
.kgsnls-sr{position:absolute!important;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}

/* toast */
.kgsnls-toast{position:fixed;left:50%;bottom:26px;transform:translate(-50%,calc(100% + 60px));opacity:0;visibility:hidden;display:inline-flex;align-items:center;gap:9px;background:#128c3d;color:#fff;font-family:'Jost','Montserrat',sans-serif;font-size:.88rem;font-weight:600;padding:13px 20px;border-radius:50px;box-shadow:0 18px 40px -12px rgba(0,0,0,.5);z-index:99999;transition:transform .4s cubic-bezier(.4,0,.2,1),opacity .3s ease,visibility .3s;pointer-events:none}
.kgsnls-toast.is-on{transform:translate(-50%,0);opacity:1;visibility:visible}
.kgsnls-toast .kgsnls-i{--kgs-is:17px}

/* ---- responsive ---- */
@media (max-width:1024px){
  .kgsnls-grid{grid-template-columns:1fr}
  .kgsnls-slider{order:1}
  .kgsnls-form{order:2}
}
@media (max-width:640px){
  .kgsnls{padding:34px 0}
  .kgsnls-wrap{padding:0 15px}
  .kgsnls-slide{padding:24px 20px}
  .kgsnls-ctrls{padding:0 18px 18px;justify-content:center}
  .kgsnls-stats{grid-template-columns:repeat(2,1fr);gap:10px}
  .kgsnls-stats b{font-size:1.8rem}
  .kgsnls-form{padding:24px 20px}
  .kgsnls-arrows{order:-1}
}

/* ---- adjacent theme section: center the feature icons above their labels ----
   The home page's "Certified / Quick Delivery / Affordable / Customer Care" row has
   icon-box widgets with inconsistent alignment baked into the page content; this scopes
   a centering fix to that one section so icons sit centered over their captions */
.elementor-element-cd65c37 .elementor-icon-box-wrapper,
.elementor-element-cd65c37 .elementor-image-box-wrapper{text-align:center!important}
.elementor-element-cd65c37 .elementor-icon-box-icon,
.elementor-element-cd65c37 .elementor-image-box-img{margin-left:auto!important;margin-right:auto!important;text-align:center!important;justify-content:center!important}
.elementor-element-cd65c37 .elementor-image-box-img img,
.elementor-element-cd65c37 .elementor-icon-box-icon img{margin-left:auto!important;margin-right:auto!important}
/* the icon row sits flush against the slider band (its own padding-top is 0);
   add breathing room so the icons don't touch the section above */
.elementor-element-cd65c37{padding-top:clamp(46px,5vw,68px)!important}
@media (prefers-reduced-motion:reduce){
  .kgsnls *,.kgsnls *::before,.kgsnls *::after{transition-duration:.01ms!important;animation-duration:.01ms!important;animation-iteration-count:1!important}
  .kgsnls-track{transition:none}
}
CSS;
			return "\n<style id=\"kgsnls-css\">" . self::minify_css( $css ) . "</style>\n";
		}

		private static function minify_css( $css ) {
			$css = preg_replace( '#/\*.*?\*/#s', '', $css );
			$css = preg_replace( '/\s*\n\s*/', '', $css );
			return trim( $css );
		}

		/** ----------------------------------------------------------------- HTML */
		private static function html() {
			$campaign = esc_url( self::CAMPAIGN_URL );
			$tel      = 'tel:+' . self::WHATSAPP;
			$wa_generic = esc_url(
				self::wa_link( 'Hi, I would like to know more about the NAVYA 10 KG Composite FTL new connection (RSP Rs.' . self::RATE_FTL . ' incl. refill). Please share the details.' )
			);

			$i_bolt   = self::icon( 'bolt' );
			$i_check  = self::icon( 'check' );
			$i_truck  = self::icon( 'truck' );
			$i_id     = self::icon( 'id' );
			$i_wallet = self::icon( 'wallet' );
			$i_shield = self::icon( 'shield' );
			$i_arrow  = self::icon( 'arrow' );
			$i_wa     = self::icon( 'whatsapp' );
			$i_phone  = self::icon( 'phone' );
			$i_rotate = self::icon( 'rotate' );
			$i_star   = self::icon( 'star' );
			$i_chev_l = self::icon( 'chev-l' );
			$i_chev_r = self::icon( 'chev-r' );

			$ftl    = esc_html( self::RATE_FTL );
			$refill = esc_html( self::RATE_REFILL );
			$wef    = esc_html( self::RATE_WEF );
			$phone  = esc_html( self::PHONE_HUMAN );

			$html = <<<HTML
<section class="kgsnls" id="kgsnls" aria-labelledby="kgsnls-title" data-autoplay="7000">
<span class="kgsnls-glow" aria-hidden="true"></span>
<div class="kgsnls-wrap">

  <div class="kgsnls-head">
    <p class="kgsnls-eyebrow">{$i_bolt} HP Navya &ndash; New Connection Available</p>
    <h2 id="kgsnls-title">Switch to <em>NAVYA</em> &mdash; the 10&nbsp;KG Composite Cylinder</h2>
    <p>New connections now available across Goa. Book now, pay later &mdash; just one ID proof and delivery within 90 minutes.</p>
  </div>

  <div class="kgsnls-grid">

    <!-- ============ SLIDER ============ -->
    <div class="kgsnls-slider" role="group" aria-roledescription="carousel" aria-label="NAVYA composite cylinder offer highlights">
      <div class="kgsnls-progress" aria-hidden="true"><i></i></div>
      <div class="kgsnls-viewport">
        <div class="kgsnls-track" id="kgsnls-track">

          <!-- slide 1 -->
          <div class="kgsnls-slide" role="group" aria-roledescription="slide" aria-label="1 of 4: New connection available">
            <p class="kgsnls-badge is-red">{$i_check} New Connection Available</p>
            <h3>NAVYA <span>10&nbsp;KG</span> Composite FTL</h3>
            <p>The new-age composite LPG cylinder &mdash; lightweight, translucent and built for the modern kitchen. Reserve yours today and pay on delivery.</p>
            <ul class="kgsnls-stats">
              <li><b>10<i>KG</i></b><small>Composite FTL</small></li>
              <li><b>90<i>MIN</i></b><small>Fast Delivery</small></li>
              <li><b>1<i>ID</i></b><small>Proof Only</small></li>
              <li><b>0<i>&#8377;</i></b><small>Pay Later</small></li>
            </ul>
            <div class="kgsnls-sc"><a class="kgsnls-link" href="{$campaign}">See full campaign details {$i_arrow}</a></div>
          </div>

          <!-- slide 2 -->
          <div class="kgsnls-slide" role="group" aria-roledescription="slide" aria-label="2 of 4: Transparent pricing">
            <p class="kgsnls-badge">{$i_wallet} Transparent Pricing</p>
            <h3>Official HP rates, <span>no hidden charges</span></h3>
            <p>Retail sale price as notified by HPCL &mdash; the same rate you would pay anywhere, delivered to your door.</p>
            <div class="kgsnls-rates">
              <div class="kgsnls-rate is-lead">
                <span>{$i_bolt} New Connection</span>
                <b><u>&#8377;</u>{$ftl}</b>
                <small>FTL &middot; 10&nbsp;KG &middot; including refill</small>
              </div>
              <div class="kgsnls-rate">
                <span>{$i_rotate} Refill</span>
                <b><u>&#8377;</u>{$refill}</b>
                <small>10&nbsp;KG &middot; per refill</small>
              </div>
            </div>
            <p class="kgsnls-wef">Rates effective {$wef}, as per HPCL and subject to change.</p>
          </div>

          <!-- slide 3 -->
          <div class="kgsnls-slide" role="group" aria-roledescription="slide" aria-label="3 of 4: Why NAVYA">
            <p class="kgsnls-badge">{$i_star} Why NAVYA</p>
            <h3>Engineered for <span>safety &amp; convenience</span></h3>
            <p>A composite body replaces heavy steel &mdash; so it is easier to handle, never rusts, and lets you see exactly how much gas is left.</p>
            <ul class="kgsnls-chips">
              <li>{$i_check} Bigger 10&nbsp;KG capacity</li>
              <li>{$i_check} Lightweight body</li>
              <li>{$i_check} Rust resistant</li>
              <li>{$i_check} Explosion-proof build</li>
              <li>{$i_check} Modern translucent design</li>
            </ul>
            <div class="kgsnls-sc"><a class="kgsnls-link" href="{$campaign}">Compare with your current cylinder {$i_arrow}</a></div>
          </div>

          <!-- slide 4 -->
          <div class="kgsnls-slide" role="group" aria-roledescription="slide" aria-label="4 of 4: How to switch">
            <p class="kgsnls-badge">{$i_id} Simple Switch</p>
            <h3>Three steps, <span>zero paperwork</span></h3>
            <ul class="kgsnls-list">
              <li><span class="kgsnls-ic">{$i_id}</span><span><strong>Share one ID proof</strong><small>Aadhaar or any valid government ID &mdash; that is all we need.</small></span></li>
              <li><span class="kgsnls-ic">{$i_truck}</span><span><strong>Delivered in 90 minutes</strong><small>Straight to your doorstep, anywhere we serve in Goa.</small></span></li>
              <li><span class="kgsnls-ic">{$i_wallet}</span><span><strong>Pay at delivery</strong><small>Book now and pay later &mdash; no advance payment required.</small></span></li>
            </ul>
            <div class="kgsnls-sc"><a class="kgsnls-link" href="{$wa_generic}" target="_blank" rel="noopener">Ask us on WhatsApp {$i_arrow}</a></div>
          </div>

        </div>
      </div>

      <div class="kgsnls-ctrls">
        <ul class="kgsnls-dots" id="kgsnls-dots" aria-label="Choose slide"></ul>
        <div class="kgsnls-arrows">
          <button type="button" class="kgsnls-arrow" id="kgsnls-prev" aria-label="Previous slide" aria-controls="kgsnls-track">{$i_chev_l}</button>
          <button type="button" class="kgsnls-arrow" id="kgsnls-next" aria-label="Next slide" aria-controls="kgsnls-track">{$i_chev_r}</button>
        </div>
      </div>
      <p class="kgsnls-sr" aria-live="polite" id="kgsnls-live"></p>
    </div>

    <!-- ============ LEAD FORM ============ -->
    <div class="kgsnls-form">
      <div class="kgsnls-form-top">
        <span class="kgsnls-form-ic">{$i_bolt}</span>
        <div>
          <h3>Reserve Your NAVYA Cylinder</h3>
          <p>Takes 30 seconds &middot; no advance payment</p>
        </div>
      </div>

      <p class="kgsnls-offer">{$i_check} Book now, pay later &mdash; limited launch stock</p>

      <form id="kgsnls-form" novalidate>
        <div class="kgsnls-fg">
          <label for="kgsnls-name">Full Name <span class="kgsnls-req">*</span></label>
          <div class="kgsnls-fw">{$i_id}<input type="text" id="kgsnls-name" name="name" placeholder="Your full name" autocomplete="name" required></div>
          <p class="kgsnls-err" id="kgsnls-name-err">Please enter your name.</p>
        </div>

        <div class="kgsnls-fg">
          <label for="kgsnls-mobile">Mobile Number <span class="kgsnls-req">*</span></label>
          <div class="kgsnls-fw">{$i_phone}<span class="kgsnls-pre">+91</span><input type="tel" id="kgsnls-mobile" name="mobile" class="kgsnls-has-pre" inputmode="numeric" maxlength="10" placeholder="10-digit number" autocomplete="tel-national" required></div>
          <p class="kgsnls-err" id="kgsnls-mobile-err">Enter a valid 10-digit mobile number.</p>
        </div>

        <div class="kgsnls-fg">
          <label for="kgsnls-location">Delivery Location <span class="kgsnls-req">*</span></label>
          <div class="kgsnls-fw">{$i_truck}<input type="text" id="kgsnls-location" name="location" placeholder="e.g. Saligao, Calangute, Mapusa" autocomplete="address-level2" required></div>
          <p class="kgsnls-err" id="kgsnls-location-err">Please tell us your location.</p>
        </div>

        <div class="kgsnls-hp" aria-hidden="true"><label for="kgsnls-website">Website</label><input type="text" id="kgsnls-website" name="website" tabindex="-1" autocomplete="off"></div>

        <button type="submit" class="kgsnls-submit">{$i_wa} Book via WhatsApp</button>
      </form>

      <p class="kgsnls-alt">or <a href="{$tel}">{$i_phone} Call {$phone}</a></p>

      <ul class="kgsnls-trust">
        <li>{$i_check} 38+ years in Saligao</li>
        <li>{$i_check} HP Gas authorized</li>
        <li>{$i_check} One ID proof only</li>
      </ul>

      <p class="kgsnls-note">Your details are sent directly to our WhatsApp &mdash; we do not store them on this website or share them with anyone.</p>
    </div>

  </div>
</div>
<div class="kgsnls-toast" id="kgsnls-toast" role="status" aria-live="polite">{$i_check} Opening WhatsApp&hellip;</div>
</section>
HTML;

			return $html;
		}

		/** ------------------------------------------------------------------- JS */
		private static function js() {
			$wa       = esc_js( self::WHATSAPP );
			$ftl      = esc_js( self::RATE_FTL );
			$relocate = (int) self::relocate_index();

			$js = <<<JS
(function(){
"use strict";
var root=document.getElementById('kgsnls');
if(!root||root.dataset.kgsnlsReady==='1'){return;}
root.dataset.kgsnlsReady='1';

/* ---- optional relocation: move block after the Nth top-level Elementor section ---- */
var REL={$relocate};
if(REL>0){
  try{
    var secs=document.querySelectorAll('.elementor-top-section');
    if(secs.length>=REL){
      var target=secs[REL-1];
      if(target&&!target.contains(root)){target.parentNode.insertBefore(root,target.nextSibling);}
    }
  }catch(e){}
}

/* ---- full-bleed: stretch the band edge-to-edge like the neighbouring stretched
       sections. Measured against documentElement.clientWidth (which excludes the
       scrollbar) so this can never introduce a horizontal scrollbar the way 100vw can.
       If anything fails the section simply stays inside its container. ---- */
function bleed(){
  try{
    root.style.marginLeft='';root.style.marginRight='';root.style.width='';
    var docW=document.documentElement.clientWidth;
    var r=root.getBoundingClientRect();
    if(docW-r.width>4){
      root.style.marginLeft=(-r.left)+'px';
      root.style.marginRight='0px';
      root.style.width=docW+'px';
    }
  }catch(e){}
}
bleed();
var bt=null;
window.addEventListener('resize',function(){
  if(bt){clearTimeout(bt);}
  bt=setTimeout(bleed,150);
});

/* ---------------------------------- carousel ---------------------------------- */
var track=document.getElementById('kgsnls-track');
var slides=track?Array.prototype.slice.call(track.children):[];
var dotsWrap=document.getElementById('kgsnls-dots');
var live=document.getElementById('kgsnls-live');
var prev=document.getElementById('kgsnls-prev');
var next=document.getElementById('kgsnls-next');
var n=slides.length,cur=0,timer=null;
var reduce=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
var dur=parseInt(root.getAttribute('data-autoplay'),10)||7000;
root.style.setProperty('--kgs-dur',dur+'ms');

var dots=[];
if(dotsWrap&&n>1){
  for(var i=0;i<n;i++){
    var li=document.createElement('li');
    var b=document.createElement('button');
    b.type='button';b.className='kgsnls-dot';
    b.setAttribute('aria-label','Go to slide '+(i+1)+' of '+n);
    b.setAttribute('aria-current',i===0?'true':'false');
    b.dataset.idx=String(i);
    li.appendChild(b);dotsWrap.appendChild(li);dots.push(b);
  }
}

function paint(){
  if(track){track.style.transform='translate3d(-'+(cur*100)+'%,0,0)';}
  for(var i=0;i<n;i++){
    var on=(i===cur);
    slides[i].setAttribute('aria-hidden',on?'false':'true');
    /* keep tab order clean: only the visible slide is focusable */
    var f=slides[i].querySelectorAll('a,button');
    for(var j=0;j<f.length;j++){
      if(on){f[j].removeAttribute('tabindex');}else{f[j].setAttribute('tabindex','-1');}
    }
    if(dots[i]){dots[i].setAttribute('aria-current',on?'true':'false');}
  }
  if(live){live.textContent='Slide '+(cur+1)+' of '+n;}
  restartBar();
}
function go(i){cur=(i+n)%n;paint();}
function nextSlide(){go(cur+1);}
function prevSlide(){go(cur-1);}

function restartBar(){
  if(reduce||!playing){return;}
  root.classList.remove('is-playing');
  /* force reflow so the CSS animation restarts */
  void root.offsetWidth;
  root.classList.add('is-playing');
}

var playing=false;
function play(){
  if(reduce||n<2||playing){return;}
  playing=true;root.classList.add('is-playing');
  timer=setInterval(nextSlide,dur);
  restartBar();
}
function pause(){
  playing=false;root.classList.remove('is-playing');
  if(timer){clearInterval(timer);timer=null;}
}

if(prev){prev.addEventListener('click',function(){pause();prevSlide();});}
if(next){next.addEventListener('click',function(){pause();nextSlide();});}
if(dotsWrap){
  dotsWrap.addEventListener('click',function(e){
    var b=e.target.closest?e.target.closest('.kgsnls-dot'):null;
    if(b){pause();go(parseInt(b.dataset.idx,10)||0);}
  });
}

/* keyboard */
root.addEventListener('keydown',function(e){
  if(e.target&&/^(INPUT|TEXTAREA|SELECT)$/.test(e.target.tagName)){return;}
  if(e.key==='ArrowRight'){pause();nextSlide();}
  else if(e.key==='ArrowLeft'){pause();prevSlide();}
});

/* pause on hover / focus within */
root.addEventListener('mouseenter',pause);
root.addEventListener('focusin',pause);
root.addEventListener('mouseleave',function(){play();});

/* touch swipe */
var sx=0,sy=0,swiping=false;
root.addEventListener('touchstart',function(e){
  if(e.touches.length!==1){return;}
  sx=e.touches[0].clientX;sy=e.touches[0].clientY;swiping=true;pause();
},{passive:true});
root.addEventListener('touchend',function(e){
  if(!swiping){return;}swiping=false;
  var t=e.changedTouches[0];
  var dx=t.clientX-sx,dy=t.clientY-sy;
  if(Math.abs(dx)>45&&Math.abs(dx)>Math.abs(dy)){ if(dx<0){nextSlide();}else{prevSlide();} }
},{passive:true});

/* only autoplay while visible */
if('IntersectionObserver' in window){
  new IntersectionObserver(function(entries){
    entries.forEach(function(en){ if(en.isIntersecting){play();}else{pause();} });
  },{threshold:.25}).observe(root);
}else{play();}
document.addEventListener('visibilitychange',function(){document.hidden?pause():play();});

paint();

/* ------------------------------------ form ------------------------------------ */
var form=document.getElementById('kgsnls-form');
var toast=document.getElementById('kgsnls-toast');
var mobile=document.getElementById('kgsnls-mobile');
if(mobile){
  mobile.addEventListener('input',function(){
    this.value=this.value.replace(/[^0-9]/g,'').slice(0,10);
    clearErr(this);
  });
}
function setErr(el,on){
  if(!el){return;}
  el.setAttribute('aria-invalid',on?'true':'false');
  var e=document.getElementById(el.id+'-err');
  if(e){e.classList.toggle('is-on',!!on);}
}
function clearErr(el){setErr(el,false);}
['kgsnls-name','kgsnls-location'].forEach(function(id){
  var el=document.getElementById(id);
  if(el){el.addEventListener('input',function(){clearErr(el);});}
});

if(form){
  form.addEventListener('submit',function(e){
    e.preventDefault();
    var name=document.getElementById('kgsnls-name');
    var loc=document.getElementById('kgsnls-location');
    var hp=document.getElementById('kgsnls-website');
    if(hp&&hp.value){return;} /* bot */

    var bad=null;
    if(!name.value.trim()){setErr(name,true);bad=bad||name;}else{clearErr(name);}
    if(!/^[0-9]{10}\$/.test(mobile.value.trim())){setErr(mobile,true);bad=bad||mobile;}else{clearErr(mobile);}
    if(!loc.value.trim()){setErr(loc,true);bad=bad||loc;}else{clearErr(loc);}
    if(bad){bad.focus();return;}

    var msg='*New NAVYA 10 KG Composite Booking*'
      +'\\n\\n*Name:* '+name.value.trim()
      +'\\n*Mobile:* +91 '+mobile.value.trim()
      +'\\n*Location:* '+loc.value.trim()
      +'\\n\\n_New Connection (FTL) — RSP Rs.{$ftl} incl. refill_'
      +'\\n_Book Now, Pay Later — via kavlekargasservice.in home page_';
    var url='https://wa.me/{$wa}?text='+encodeURIComponent(msg);

    if(toast){toast.classList.add('is-on');setTimeout(function(){toast.classList.remove('is-on');},3200);}
    var w=window.open(url,'_blank','noopener');
    if(!w){window.location.href=url;}
    form.reset();
  });
}
})();
JS;
			return "\n<script id=\"kgsnls-js\">" . $js . "</script>\n";
		}
	}

	KGS_Navya_Lead_Slider::init();

endif;
