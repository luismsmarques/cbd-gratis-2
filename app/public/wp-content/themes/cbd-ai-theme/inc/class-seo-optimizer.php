<?php
/**
 * SEO Optimizer for CBD Content
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_SEO_Optimizer {
	
	/**
	 * Gemini API instance
	 */
	private $gemini;
	
	/**
	 * Target keywords
	 */
	private $target_keywords = array(
		'CBD',
		'canabidiol',
		'óleo de cânhamo',
		'cânhamo',
		'cannabis medicinal',
		'CBD para cães',
		'CBD para gatos',
		'canabidiol para caes',
		'cbd gatos',
		'cbd e legal em portugal',
		'cbd legislação portugal',
	);
	
	/**
	 * Synonyms mapping
	 */
	private $synonyms = array(
		'CBD' => array( 'canabidiol', 'óleo de cânhamo', 'cannabidiol' ),
		'canabidiol' => array( 'CBD', 'cannabidiol', 'óleo de cânhamo' ),
		'cânhamo' => array( 'cannabis', 'hemp' ),
		'cannabis' => array( 'cânhamo', 'hemp' ),
	);
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->gemini = new CBD_Gemini_API();
	}
	
	/**
	 * Analyze content for SEO
	 *
	 * @param string $content Content to analyze
	 * @param string $title Title of the content
	 * @return array Analysis results
	 */
	public function analyze_content( $content, $title = '' ) {
		$analysis = array(
			'word_count' => str_word_count( $content ),
			'keyword_density' => array(),
			'score' => 0,
			'suggestions' => array(),
		);
		
		// Calculate keyword density
		$content_lower = mb_strtolower( $content, 'UTF-8' );
		$words = str_word_count( $content_lower, 1 );
		$total_words = count( $words );
		
		foreach ( $this->target_keywords as $keyword ) {
			$keyword_lower = mb_strtolower( $keyword, 'UTF-8' );
			$count = substr_count( $content_lower, $keyword_lower );
			$density = $total_words > 0 ? ( $count / $total_words ) * 100 : 0;
			
			$analysis['keyword_density'][ $keyword ] = array(
				'count' => $count,
				'density' => round( $density, 2 ),
				'status' => $this->get_density_status( $density ),
			);
		}
		
		// Calculate overall SEO score
		$analysis['score'] = $this->calculate_seo_score( $analysis, $title, $content );
		
		// Generate suggestions
		$analysis['suggestions'] = $this->generate_suggestions( $content, $title, $analysis );
		
		return $analysis;
	}
	
	/**
	 * Get density status
	 *
	 * @param float $density Density percentage
	 * @return string Status
	 */
	private function get_density_status( $density ) {
		if ( $density >= 1.0 && $density <= 3.0 ) {
			return 'optimal';
		} elseif ( $density > 3.0 ) {
			return 'too_high';
		} elseif ( $density > 0 ) {
			return 'low';
		} else {
			return 'missing';
		}
	}
	
	/**
	 * Calculate SEO score
	 *
	 * @param array  $analysis Analysis data
	 * @param string $title Title
	 * @param string $content Content
	 * @return int Score (0-100)
	 */
	private function calculate_seo_score( $analysis, $title, $content ) {
		$score = 0;
		
		// Keyword density score (40 points)
		$optimal_keywords = 0;
		foreach ( $analysis['keyword_density'] as $keyword_data ) {
			if ( $keyword_data['status'] === 'optimal' ) {
				$optimal_keywords++;
			}
		}
		$score += min( 40, ( $optimal_keywords / count( $this->target_keywords ) ) * 40 );
		
		// Title optimization (20 points)
		if ( ! empty( $title ) ) {
			$title_lower = mb_strtolower( $title, 'UTF-8' );
			$has_keyword = false;
			foreach ( $this->target_keywords as $keyword ) {
				if ( stripos( $title_lower, mb_strtolower( $keyword, 'UTF-8' ) ) !== false ) {
					$has_keyword = true;
					break;
				}
			}
			if ( $has_keyword ) {
				$score += 20;
			}
		}
		
		// Content length (20 points)
		$word_count = $analysis['word_count'];
		if ( $word_count >= 1000 ) {
			$score += 20;
		} elseif ( $word_count >= 500 ) {
			$score += 15;
		} elseif ( $word_count >= 300 ) {
			$score += 10;
		}
		
		// Keyword variation (20 points)
		$variations = $this->check_keyword_variations( $content );
		$score += min( 20, ( $variations / 3 ) * 20 );
		
		return round( $score );
	}
	
	/**
	 * Check keyword variations in content
	 *
	 * @param string $content Content
	 * @return int Number of variations found
	 */
	private function check_keyword_variations( $content ) {
		$content_lower = mb_strtolower( $content, 'UTF-8' );
		$variations_found = 0;
		
		foreach ( $this->synonyms as $main_keyword => $synonyms ) {
			$has_main = stripos( $content_lower, mb_strtolower( $main_keyword, 'UTF-8' ) ) !== false;
			$has_synonym = false;
			
			foreach ( $synonyms as $synonym ) {
				if ( stripos( $content_lower, mb_strtolower( $synonym, 'UTF-8' ) ) !== false ) {
					$has_synonym = true;
					break;
				}
			}
			
			if ( $has_main && $has_synonym ) {
				$variations_found++;
			}
		}
		
		return $variations_found;
	}
	
	/**
	 * Generate suggestions for improvement
	 *
	 * @param string $content Content
	 * @param string $title Title
	 * @param array  $analysis Analysis data
	 * @return array Suggestions
	 */
	private function generate_suggestions( $content, $title, $analysis ) {
		$suggestions = array();
		
		// Check for missing keywords
		foreach ( $analysis['keyword_density'] as $keyword => $data ) {
			if ( $data['status'] === 'missing' ) {
				$suggestions[] = sprintf(
					'Adicione a palavra-chave "%s" ao conteúdo para melhorar o SEO.',
					$keyword
				);
			} elseif ( $data['status'] === 'too_high' ) {
				$suggestions[] = sprintf(
					'Reduza o uso da palavra-chave "%s" (densidade atual: %.2f%%) para evitar keyword stuffing.',
					$keyword,
					$data['density']
				);
			}
		}
		
		// Suggest synonyms
		$suggestions = array_merge( $suggestions, $this->suggest_variations( $content ) );
		
		// Title suggestions
		if ( ! empty( $title ) ) {
			$title_lower = mb_strtolower( $title, 'UTF-8' );
			$has_keyword = false;
			foreach ( $this->target_keywords as $keyword ) {
				if ( stripos( $title_lower, mb_strtolower( $keyword, 'UTF-8' ) ) !== false ) {
					$has_keyword = true;
					break;
				}
			}
			if ( ! $has_keyword ) {
				$suggestions[] = 'Adicione uma palavra-chave relevante ao título para melhorar o SEO.';
			}
		}
		
		return $suggestions;
	}
	
	/**
	 * Suggest keyword variations using AI
	 *
	 * @param string $content Content
	 * @return array Suggestions
	 */
	public function suggest_variations( $content ) {
		$prompt = sprintf(
			'Analise o seguinte texto sobre CBD e sugira variações e sinônimos naturais que podem ser usados para melhorar o SEO sem alterar o significado. Foque em palavras como: CBD, canabidiol, óleo de cânhamo, cânhamo, cannabis.\n\nTexto: %s\n\nSugestões (formato: palavra original → sinônimo sugerido):',
			substr( $content, 0, 1000 )
		);
		
		$result = $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.5,
			'max_tokens' => 300,
		) );
		
		if ( is_wp_error( $result ) ) {
			return array();
		}
		
		// Parse suggestions
		$suggestions = array();
		$lines = explode( "\n", $result );
		
		foreach ( $lines as $line ) {
			$line = trim( $line );
			if ( preg_match( '/(.+?)\s*[→-]\s*(.+)/', $line, $matches ) ) {
				$suggestions[] = sprintf(
					'Considere usar "%s" como alternativa a "%s"',
					trim( $matches[2] ),
					trim( $matches[1] )
				);
			}
		}
		
		return $suggestions;
	}
	
	/**
	 * Optimize article content
	 *
	 * @param string $content Original content
	 * @param string $title Title
	 * @return array|WP_Error Optimized content and suggestions
	 */
	public function optimize_article( $content, $title = '' ) {
		$analysis = $this->analyze_content( $content, $title );
		
		$prompt = sprintf(
			'Otimize o seguinte artigo sobre CBD para melhorar o SEO, mantendo o significado e a qualidade do conteúdo. Use variações naturais de palavras-chave (CBD, canabidiol, óleo de cânhamo, cânhamo) e melhore a estrutura se necessário.\n\nTítulo: %s\n\nConteúdo:\n%s\n\nArtigo otimizado:',
			$title,
			$content
		);
		
		$optimized = $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.6,
			'max_tokens' => strlen( $content ) * 2,
		) );
		
		if ( is_wp_error( $optimized ) ) {
			return $optimized;
		}
		
		return array(
			'original_analysis' => $analysis,
			'optimized_content' => $optimized,
			'new_analysis' => $this->analyze_content( $optimized, $title ),
		);
	}
	
	/**
	 * Generate meta description
	 *
	 * @param string $content Content
	 * @param string $title Title
	 * @return string|WP_Error Meta description or error
	 */
	public function generate_meta( $content, $title = '' ) {
		$prompt = sprintf(
			'Gere uma meta description otimizada para SEO (120-160 caracteres) em português para o seguinte conteúdo sobre CBD. Inclua palavras-chave relevantes naturalmente:\n\nTítulo: %s\n\nConteúdo: %s\n\nMeta description:',
			$title,
			wp_trim_words( $content, 50 )
		);
		
		$meta = $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.5,
			'max_tokens' => 50,
		) );
		
		if ( is_wp_error( $meta ) ) {
			return $meta;
		}
		
		// Ensure proper length
		$meta = trim( $meta );
		if ( strlen( $meta ) > 160 ) {
			$meta = substr( $meta, 0, 157 ) . '...';
		}
		
		return $meta;
	}
}

