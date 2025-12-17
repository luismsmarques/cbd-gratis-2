<?php
/**
 * Content Generator using AI
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Content_Generator {
	
	/**
	 * Gemini API instance
	 */
	private $gemini;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->gemini = new CBD_Gemini_API();
	}
	
	/**
	 * Generate article about CBD for animals
	 *
	 * @param string $topic Topic of the article
	 * @param string $animal_type Animal type (cão, gato, etc.)
	 * @param int    $word_count Target word count
	 * @return array|WP_Error Generated content or error
	 */
	public function generate_article( $topic, $animal_type = '', $word_count = 1000 ) {
		$prompt = sprintf(
			'Escreva um artigo completo e bem estruturado em português sobre "%s" relacionado a CBD para animais%s. O artigo deve ter aproximadamente %d palavras, ser informativo, preciso e otimizado para SEO. Inclua:\n\n1. Introdução envolvente\n2. Seções bem organizadas com subtítulos\n3. Informações práticas e úteis\n4. Conclusão com resumo dos pontos principais\n5. Use palavras-chave naturalmente: canabidiol, CBD, óleo de cânhamo, cannabis medicinal\n\nArtigo:',
			$topic,
			! empty( $animal_type ) ? sprintf( ' (focado em %s)', $animal_type ) : '',
			$word_count
		);
		
		$content = $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.8,
			'max_tokens' => $word_count * 2, // Approximate token count
		) );
		
		if ( is_wp_error( $content ) ) {
			return $content;
		}
		
		// Generate title
		$title = $this->generate_title( $topic, $animal_type );
		
		// Generate meta description
		$meta_description = $this->generate_meta_description( $content );
		
		// Extract keywords
		$keywords = $this->gemini->extract_keywords( $content );
		
		return array(
			'title' => is_wp_error( $title ) ? $topic : $title,
			'content' => $content,
			'meta_description' => is_wp_error( $meta_description ) ? '' : $meta_description,
			'keywords' => is_wp_error( $keywords ) ? array() : $keywords,
		);
	}
	
	/**
	 * Generate FAQ about CBD
	 *
	 * @param string $topic Topic for FAQ
	 * @param int    $question_count Number of questions
	 * @return array|WP_Error FAQ content or error
	 */
	public function generate_faq( $topic, $question_count = 5 ) {
		$prompt = sprintf(
			'Crie uma lista de %d perguntas frequentes (FAQ) sobre "%s" relacionado a CBD para animais. Para cada pergunta, forneça uma resposta completa e útil em português. Formate como:\n\nP: Pergunta\nR: Resposta\n\nFAQ:',
			$question_count,
			$topic
		);
		
		$content = $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.7,
			'max_tokens' => 1500,
		) );
		
		if ( is_wp_error( $content ) ) {
			return $content;
		}
		
		// Parse FAQ into structured format
		$faqs = $this->parse_faq( $content );
		
		return array(
			'content' => $content,
			'faqs' => $faqs,
		);
	}
	
	/**
	 * Generate dosage guide
	 *
	 * @param string $animal_type Animal type
	 * @return array|WP_Error Guide content or error
	 */
	public function generate_guide( $animal_type = 'cão' ) {
		$prompt = sprintf(
			'Crie um guia completo de dosagem de CBD para %s em português. Inclua:\n\n1. Como calcular a dose baseada no peso\n2. Tabela de dosagem por peso\n3. Frequência de administração\n4. Sinais de dosagem adequada\n5. Sinais de sobredosagem\n6. Quando consultar um veterinário\n\nGuia:',
			$animal_type
		);
		
		$content = $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.6,
			'max_tokens' => 2000,
		) );
		
		if ( is_wp_error( $content ) ) {
			return $content;
		}
		
		return array(
			'content' => $content,
			'animal_type' => $animal_type,
		);
	}
	
	/**
	 * Generate title for content
	 *
	 * @param string $topic Topic
	 * @param string $animal_type Animal type
	 * @return string|WP_Error Title or error
	 */
	private function generate_title( $topic, $animal_type = '' ) {
		$prompt = sprintf(
			'Gere um título SEO otimizado em português para um artigo sobre "%s"%s relacionado a CBD para animais. O título deve ser atraente, ter entre 50-60 caracteres e incluir palavras-chave relevantes.',
			$topic,
			! empty( $animal_type ) ? sprintf( ' para %s', $animal_type ) : ''
		);
		
		return $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.7,
			'max_tokens' => 50,
		) );
	}
	
	/**
	 * Generate meta description
	 *
	 * @param string $content Content to summarize
	 * @return string|WP_Error Meta description or error
	 */
	private function generate_meta_description( $content ) {
		$summary = $this->gemini->summarize_text( $content, 25 );
		
		if ( is_wp_error( $summary ) ) {
			return $summary;
		}
		
		// Ensure it's between 120-160 characters for SEO
		$meta = wp_trim_words( $summary, 25 );
		
		if ( strlen( $meta ) < 120 ) {
			$meta = $summary;
		}
		
		return substr( $meta, 0, 160 );
	}
	
	/**
	 * Parse FAQ content into structured format
	 *
	 * @param string $content FAQ content
	 * @return array Parsed FAQs
	 */
	private function parse_faq( $content ) {
		$faqs = array();
		$lines = explode( "\n", $content );
		
		$current_question = '';
		$current_answer = '';
		
		foreach ( $lines as $line ) {
			$line = trim( $line );
			
			if ( empty( $line ) ) {
				continue;
			}
			
			if ( preg_match( '/^[PQ]:\s*(.+)$/i', $line, $matches ) ) {
				// Save previous Q&A if exists
				if ( ! empty( $current_question ) ) {
					$faqs[] = array(
						'question' => $current_question,
						'answer' => trim( $current_answer ),
					);
				}
				$current_question = $matches[1];
				$current_answer = '';
			} elseif ( preg_match( '/^[AR]:\s*(.+)$/i', $line, $matches ) ) {
				$current_answer .= ' ' . $matches[1];
			} elseif ( ! empty( $current_question ) ) {
				$current_answer .= ' ' . $line;
			}
		}
		
		// Add last Q&A
		if ( ! empty( $current_question ) ) {
			$faqs[] = array(
				'question' => $current_question,
				'answer' => trim( $current_answer ),
			);
		}
		
		return $faqs;
	}
}

