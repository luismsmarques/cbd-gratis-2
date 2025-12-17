<?php
/**
 * Chatbot Handler for Portuguese Legislation
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class CBD_Legislation_Chatbot_Handler {
	
	/**
	 * Gemini API instance
	 */
	private $gemini;
	
	/**
	 * Legislation Monitor instance
	 */
	private $monitor;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->gemini = new CBD_Gemini_API();
		$this->monitor = new CBD_Legislation_Monitor();
	}
	
	/**
	 * Classify user question
	 *
	 * @param string $question User question
	 * @return string Category
	 */
	public function classify_question( $question ) {
		$categories = array(
			'legalidade',
			'legislacao_portugal',
			'legislacao_ue',
			'infarmed',
			'dre',
			'comercializacao',
			'importacao',
			'prescricao',
			'geral',
		);
		
		$category = $this->gemini->classify_text( $question, $categories );
		
		if ( is_wp_error( $category ) ) {
			return 'geral';
		}
		
		return $category;
	}
	
	/**
	 * Get response for user question
	 *
	 * @param string $question User question
	 * @return array Response data
	 */
	public function get_response( $question ) {
		$category = $this->classify_question( $question );
		
		// Get recent alerts for context
		$recent_alerts = $this->monitor->get_recent_alerts( 5 );
		
		// Build context-aware prompt
		$context = $this->build_context( $category, $recent_alerts );
		
		$prompt = sprintf(
			'Você é um especialista em legislação portuguesa e europeia sobre CBD e cannabis medicinal. Responda à seguinte pergunta de forma clara, precisa e útil, sempre referenciando a legislação atual e atualizada.\n\n%s\n\nPergunta: %s\n\nResposta (em português, de forma clara e acessível):',
			$context,
			$question
		);
		
		$response = $this->gemini->generate_text( $prompt, array(
			'temperature' => 0.7,
			'max_tokens'  => 600,
		) );
		
		if ( is_wp_error( $response ) ) {
			return array(
				'success' => false,
				'message' => 'Desculpe, ocorreu um erro ao processar sua pergunta. Tente novamente.',
				'category' => $category,
			);
		}
		
		// Get related alerts
		$related_alerts = $this->get_related_alerts( $category, $question );
		
		return array(
			'success' => true,
			'message' => $response,
			'category' => $category,
			'related_alerts' => $related_alerts,
			'legal_info' => $this->get_legal_info( $category ),
		);
	}
	
	/**
	 * Build context for prompt
	 *
	 * @param string $category Category
	 * @param array  $recent_alerts Recent alerts
	 * @return string Context string
	 */
	private function build_context( $category, $recent_alerts ) {
		$context_parts = array();
		
		// Base context
		$context_parts[] = 'Contexto: Você está respondendo sobre legislação portuguesa e europeia relacionada a CBD, canabidiol, cânhamo e cannabis medicinal.';
		
		// Category-specific context
		switch ( $category ) {
			case 'legalidade':
				$context_parts[] = 'Foco: Legalidade do CBD em Portugal, requisitos legais, conformidade.';
				break;
			case 'legislacao_portugal':
				$context_parts[] = 'Foco: Legislação nacional portuguesa sobre CBD e cannabis medicinal.';
				break;
			case 'legislacao_ue':
				$context_parts[] = 'Foco: Legislação da União Europeia que afeta Portugal.';
				break;
			case 'infarmed':
				$context_parts[] = 'Foco: Regulamentação do Infarmed sobre produtos com CBD.';
				break;
			case 'dre':
				$context_parts[] = 'Foco: Decretos e leis publicados no Diário da República.';
				break;
			case 'comercializacao':
				$context_parts[] = 'Foco: Regras para comercialização de produtos com CBD em Portugal.';
				break;
			case 'importacao':
				$context_parts[] = 'Foco: Regulamentação sobre importação de produtos com CBD.';
				break;
			case 'prescricao':
				$context_parts[] = 'Foco: Requisitos para prescrição médica de produtos com CBD.';
				break;
		}
		
		// Add recent alerts context
		if ( ! empty( $recent_alerts ) ) {
			$context_parts[] = 'Alertas Legislativos Recentes:';
			foreach ( array_slice( $recent_alerts, 0, 3 ) as $alert ) {
				$context_parts[] = sprintf( '- %s (%s): %s', $alert['title'], $alert['date'], wp_trim_words( $alert['excerpt'], 15 ) );
			}
		}
		
		$context_parts[] = 'Importante: Sempre mencione que as informações são baseadas na legislação atual e que mudanças podem ocorrer. Recomende consultar fontes oficiais para informações precisas.';
		
		return implode( "\n", $context_parts );
	}
	
	/**
	 * Get related alerts
	 *
	 * @param string $category Category
	 * @param string $question Question
	 * @return array Related alerts
	 */
	private function get_related_alerts( $category, $question ) {
		$all_alerts = $this->monitor->get_recent_alerts( 20 );
		$related = array();
		
		// Simple keyword matching
		$keywords = explode( ' ', strtolower( $question ) );
		
		foreach ( $all_alerts as $alert ) {
			$alert_text = strtolower( $alert['title'] . ' ' . $alert['excerpt'] );
			
			foreach ( $keywords as $keyword ) {
				if ( strlen( $keyword ) > 3 && strpos( $alert_text, $keyword ) !== false ) {
					$related[] = array(
						'title' => $alert['title'],
						'url' => $alert['url'],
						'date' => $alert['date'],
					);
					break;
				}
			}
			
			if ( count( $related ) >= 3 ) {
				break;
			}
		}
		
		return $related;
	}
	
	/**
	 * Get legal information
	 *
	 * @param string $category Category
	 * @return array Legal info
	 */
	private function get_legal_info( $category ) {
		$info = array();
		
		switch ( $category ) {
			case 'legalidade':
			case 'comercializacao':
				$info['source'] = 'Infarmed / Diário da República';
				$info['last_update'] = date_i18n( 'd/m/Y' );
				break;
			case 'legislacao_ue':
				$info['source'] = 'EUR-Lex / União Europeia';
				$info['last_update'] = date_i18n( 'd/m/Y' );
				break;
		}
		
		return $info;
	}
}

