<?php
/**
 * Template Name: CBD para Pessoas
 * 
 * Página especializada em CBD para uso humano
 * Design MUI focado em rigor, segurança e inovação
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get URLs for internal linking
$animais_url = '';
$legislacao_url = '';
$calculadora_url = '';

$animais_page = get_page_by_path( 'cbd-para-animais' );
if ( ! $animais_page ) {
	$animais_page = get_page_by_path( 'animais' );
}
if ( $animais_page ) {
	$animais_url = get_permalink( $animais_page->ID );
}

$legislacao_page = get_page_by_path( 'monitor-legislacao' );
if ( ! $legislacao_page ) {
	$legislacao_page = get_page_by_path( 'legislacao' );
}
if ( $legislacao_page ) {
	$legislacao_url = get_permalink( $legislacao_page->ID );
}

$calculadora_page = get_page_by_path( 'calculadora-de-dosagem' );
if ( ! $calculadora_page ) {
	$calculadora_page = get_page_by_path( 'calculadora-dosagem' );
}
if ( $calculadora_page ) {
	$calculadora_url = get_permalink( $calculadora_page->ID );
}
?>

<!-- Hero Section - MUI Design Portal de Saúde -->
<main class="main-content">
	<section class="hero-humanos py-12 md:py-20" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(25, 118, 210, 0.05), var(--mui-gray-50));">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto text-center">
				<!-- Trust Badge - MUI Chip -->
				<div class="mui-chip mui-chip-primary mb-6" style="display: inline-flex;">
					<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
					</svg>
					<span>Informação Baseada em Evidências Científicas</span>
				</div>
				
				<h1 class="mui-typography-h1 mb-6">
					<?php echo esc_html( cbd_ai_get_humanos_h1() ); ?>
				</h1>
				
				<p class="mui-typography-body1 mb-8" style="max-width: 640px; margin-left: auto; margin-right: auto; color: var(--mui-gray-700);">
					O guia mais completo sobre CBD em Portugal. Descubra como o óleo de CBD pode ajudar na dor, ansiedade e sono. Informação 100% legal e baseada em evidências.
				</p>
				
				<!-- Condition Keywords (SEO) - MUI Chips -->
				<div class="mui-chips-container" style="justify-content: center;">
					<span class="mui-chip">CBD para ansiedade</span>
					<span class="mui-chip">CBD para dores crónicas</span>
					<span class="mui-chip">CBD para dormir</span>
					<span class="mui-chip">dosagem CBD humanos</span>
				</div>
			</div>
		</div>
	</section>

	<!-- CBD Definition Section - MUI Card -->
	<section class="definition-section py-16 md:py-20">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto">
				<h2 class="mui-typography-h2 mb-8 text-center">
					O que é CBD?
				</h2>
				<div class="mui-card mui-card-elevated">
					<div class="mui-card-content">
						<p class="mui-typography-body1 mb-4">
							<strong>CBD (canabidiol)</strong> é um composto natural extraído da planta <em>Cannabis sativa</em>, especificamente do cânhamo. Ao contrário do THC (tetrahidrocanabinol), o CBD não possui efeitos psicoativos e não causa "high" ou alterações de consciência. O CBD interage com o <strong>sistema endocanabinoide</strong> presente no corpo humano, um sistema complexo de neurotransmissores e recetores que regula funções como sono, humor, apetite, dor e resposta imune. Esta interação permite que o CBD possa influenciar positivamente estas funções sem os efeitos intoxicantes associados ao THC.
						</p>
						<p class="mui-typography-body1" style="margin: 0;">
							O mecanismo de ação do CBD envolve principalmente a modulação de recetores CB1 e CB2 do sistema endocanabinoide, bem como a interação com outros sistemas de neurotransmissores, incluindo serotonina e dopamina. Esta ação multifacetada explica porque o CBD pode ter aplicações em diversas condições de saúde.
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Benefits Section - MUI Cards Grid -->
	<section class="benefits-section py-16 md:py-20" style="background: var(--mui-gray-50);">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						Benefícios do CBD para Pessoas
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Principais benefícios clinicamente estudados do CBD para uso humano
					</p>
				</header>
				
				<!-- Benefits Grid - 3 columns on desktop -->
				<div id="benefits-grid" class="mb-12">
					<?php
					$benefits = array(
						array(
							'title' => 'CBD para Ansiedade',
							'description' => 'Estudos clínicos demonstram que o CBD pode reduzir sintomas de ansiedade em humanos, incluindo ansiedade social, transtorno de pânico e ansiedade generalizada, através da modulação dos recetores de serotonina (5-HT1A).',
							'icon' => '😰',
							'color' => 'var(--mui-blue-primary)'
						),
						array(
							'title' => 'CBD para Dores Crónicas',
							'description' => 'O CBD pode ajudar no tratamento de dores crónicas, incluindo dor neuropática, artrite reumatoide e fibromialgia, através da interação com recetores do sistema endocanabinoide envolvidos na percepção da dor.',
							'icon' => '💊',
							'color' => 'var(--mui-teal-primary)'
						),
						array(
							'title' => 'CBD para Dormir',
							'description' => 'O CBD pode melhorar a qualidade do sono ao reduzir a ansiedade e promover o relaxamento, ajudando pessoas com insónia ou distúrbios do sono relacionados ao stress.',
							'icon' => '😴',
							'color' => 'var(--mui-info)'
						),
						array(
							'title' => 'Propriedades Anti-inflamatórias',
							'description' => 'O CBD possui propriedades anti-inflamatórias comprovadas que podem ajudar em condições inflamatórias crónicas, incluindo doenças autoimunes, artrite e condições inflamatórias do sistema digestivo.',
							'icon' => '🔥',
							'color' => 'var(--mui-warning)'
						),
						array(
							'title' => 'Tratamento de Epilepsia',
							'description' => 'O CBD aprovado pelo Infarmed (Epidyolex) é usado clinicamente para tratar formas raras de epilepsia em crianças e adultos, com eficácia comprovada em estudos clínicos.',
							'icon' => '⚡',
							'color' => 'var(--mui-success)'
						),
						array(
							'title' => 'CBD para Saúde Mental',
							'description' => 'Pesquisas preliminares sugerem potencial do CBD em condições de saúde mental, sempre como complemento ao tratamento médico convencional.',
							'icon' => '🧠',
							'color' => 'var(--mui-blue-primary)'
						),
					);
					
					foreach ( $benefits as $index => $benefit ) :
					?>
						<div class="mui-card mui-card-elevated">
							<div class="mui-card-content">
								<div style="display: flex; gap: 16px; align-items: flex-start;">
									<div style="flex-shrink: 0; width: 48px; height: 48px; background-color: rgba(25, 118, 210, 0.12); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">
										<?php echo esc_html( $benefit['icon'] ); ?>
									</div>
									<div style="flex: 1;">
										<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">
											<?php echo esc_html( $benefit['title'] ); ?>
										</h3>
										<p class="mui-typography-body2" style="margin: 0;">
											<?php echo esc_html( $benefit['description'] ); ?>
										</p>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- Dosage Table Section - MUI Table -->
	<section class="dosage-section py-16 md:py-20">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						Guia de Dosagem de CBD para Pessoas
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Tabela de dosagem sugerida por condição e uso
					</p>
				</header>
				
				<!-- Dosage Table - MUI Table -->
				<div class="mui-table-container mb-8">
					<table class="mui-table">
						<thead>
							<tr>
								<th class="mui-table-head">Condição/Uso</th>
								<th class="mui-table-head" style="text-align: center;">Dose Inicial (mg/dia)</th>
								<th class="mui-table-head" style="text-align: center;">Dose Manutenção (mg/dia)</th>
								<th class="mui-table-head" style="text-align: center;">Frequência</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="mui-table-cell">Ansiedade Geral</td>
								<td class="mui-table-cell" style="text-align: center;">5-10 mg</td>
								<td class="mui-table-cell" style="text-align: center;">10-30 mg</td>
								<td class="mui-table-cell" style="text-align: center;">2x ao dia</td>
							</tr>
							<tr>
								<td class="mui-table-cell">Dores Crónicas</td>
								<td class="mui-table-cell" style="text-align: center;">10-20 mg</td>
								<td class="mui-table-cell" style="text-align: center;">20-50 mg</td>
								<td class="mui-table-cell" style="text-align: center;">2-3x ao dia</td>
							</tr>
							<tr>
								<td class="mui-table-cell">Insónia / Problemas de Sono</td>
								<td class="mui-table-cell" style="text-align: center;">10-20 mg</td>
								<td class="mui-table-cell" style="text-align: center;">20-40 mg</td>
								<td class="mui-table-cell" style="text-align: center;">1x antes de dormir</td>
							</tr>
							<tr>
								<td class="mui-table-cell">Inflamação</td>
								<td class="mui-table-cell" style="text-align: center;">10-15 mg</td>
								<td class="mui-table-cell" style="text-align: center;">15-40 mg</td>
								<td class="mui-table-cell" style="text-align: center;">2x ao dia</td>
							</tr>
							<tr>
								<td class="mui-table-cell">Uso Geral / Bem-estar</td>
								<td class="mui-table-cell" style="text-align: center;">5-10 mg</td>
								<td class="mui-table-cell" style="text-align: center;">10-25 mg</td>
								<td class="mui-table-cell" style="text-align: center;">1-2x ao dia</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<!-- Dosage Disclaimer - MUI Alert -->
				<div class="mui-alert mui-alert-warning mui-alert-elevated">
					<div class="mui-alert-icon">⚠</div>
					<div class="mui-alert-message">
						<p class="mui-typography-body2" style="margin: 0;">
							<strong>Importante:</strong> Estas são diretrizes gerais baseadas em estudos científicos. A dosagem ideal de CBD varia significativamente entre indivíduos, dependendo de fatores como peso corporal, metabolismo, condição de saúde e sensibilidade individual. Sempre consulte um médico antes de iniciar o uso de CBD, especialmente se estiver a tomar outros medicamentos ou tiver condições de saúde pré-existentes. Comece sempre com a dose mais baixa e aumente gradualmente se necessário.
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Legal Status Section - MUI Card -->
	<section class="legal-section py-16 md:py-20" style="background: var(--mui-gray-50);">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						Status Legal do CBD em Portugal para Uso Humano
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Informação atualizada sobre a legalidade do CBD em Portugal
					</p>
				</header>
				
				<div class="mui-card mui-card-elevated">
					<div class="mui-card-content">
						<h3 class="mui-typography-h4 mb-4" style="font-weight: 600;">CBD Legal em Portugal</h3>
						<p class="mui-typography-body1 mb-4">
							Em Portugal, o <strong>CBD é legal para uso humano</strong> desde que o produto final contenha um teor de THC inferior ao limite legal estabelecido pela União Europeia (0,2% ou menos). A comercialização de produtos de CBD para uso tópico e cosmético é permitida, enquanto produtos para consumo oral requerem autorização do <strong>Infarmed</strong> (Autoridade Nacional do Medicamento e Produtos de Saúde).
						</p>
						<p class="mui-typography-body1 mb-4">
							A legislação portuguesa segue as diretrizes da União Europeia sobre cânhamo industrial e cannabis medicinal. Produtos de CBD derivados de cânhamo com menos de 0,2% de THC podem ser comercializados como suplementos alimentares ou cosméticos, desde que cumpram os regulamentos específicos de cada categoria.
						</p>
						<p class="mui-typography-body1 mb-6">
							Para uso medicinal, o CBD requer prescrição médica e aprovação do Infarmed. O medicamento <strong>Epidyolex</strong> (CBD puro) está aprovado em Portugal para o tratamento de formas raras de epilepsia.
						</p>
						
						<!-- Internal Link to Legislation Monitor - MUI Alert -->
						<?php if ( $legislacao_url ) : ?>
						<div class="mui-alert mui-alert-info mb-6">
							<div class="mui-alert-icon">ℹ</div>
							<div class="mui-alert-message">
								<h4 class="mui-typography-subtitle1 mb-2" style="font-weight: 600;">Consulte o nosso Monitor de Legislação</h4>
								<p class="mui-typography-body2" style="margin: 0;">
									Para informações atualizadas sobre alterações na legislação portuguesa sobre CBD, consulte o nosso <a href="<?php echo esc_url( $legislacao_url ); ?>" class="mui-button mui-button-text" style="color: var(--mui-blue-primary);">Monitor de Legislação Portuguesa sobre CBD</a>. Este sistema monitoriza automaticamente fontes oficiais como Infarmed e Diário da República para garantir que a informação está sempre atualizada.
								</p>
							</div>
						</div>
						<?php endif; ?>
						
						<!-- External Authority Links (E-E-A-T) - MUI List -->
						<div style="border-top: 1px solid var(--mui-gray-200); padding-top: 24px;">
							<h4 class="mui-typography-h6 mb-4" style="font-weight: 600;">Fontes Oficiais de Informação</h4>
							<ul class="mui-list">
								<li class="mui-list-item">
									<a href="https://www.infarmed.pt" target="_blank" rel="noopener noreferrer" class="mui-list-item-text" style="text-decoration: none; display: flex; align-items: center; gap: 8px;">
										<svg style="width: 20px; height: 20px; color: var(--mui-blue-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
										</svg>
										<strong>Infarmed</strong> - Autoridade Nacional do Medicamento e Produtos de Saúde
									</a>
								</li>
								<li class="mui-list-item">
									<a href="https://dre.pt" target="_blank" rel="noopener noreferrer" class="mui-list-item-text" style="text-decoration: none; display: flex; align-items: center; gap: 8px;">
										<svg style="width: 20px; height: 20px; color: var(--mui-blue-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
										</svg>
										<strong>Diário da República</strong> - Legislação oficial portuguesa
									</a>
								</li>
								<li class="mui-list-item">
									<div class="mui-list-item-text" style="display: flex; align-items: center; gap: 8px;">
										<svg style="width: 20px; height: 20px; color: var(--mui-blue-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
										</svg>
										<span><strong>União Europeia:</strong> Regulamento (UE) 2021/2115 sobre cânhamo industrial</span>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Strategic Internal Links Section - MUI Cards -->
	<section class="internal-links-section py-16 md:py-20">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						Explore Mais Conteúdo sobre CBD
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Links para outras páginas relevantes do nosso site
					</p>
				</header>
				
				<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
					<?php if ( $animais_url ) : ?>
					<div class="mui-card mui-card-elevated" style="transition: all 0.3s ease;">
						<a href="<?php echo esc_url( $animais_url ); ?>" style="text-decoration: none; display: block;">
							<div class="mui-card-content">
								<div style="display: flex; gap: 16px; align-items: flex-start;">
									<div style="font-size: 48px; flex-shrink: 0;">🐾</div>
									<div style="flex: 1;">
										<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">
											CBD para Animais
										</h3>
										<p class="mui-typography-body2 mb-4" style="color: var(--mui-gray-600);">
											Descubra como o CBD pode ajudar cães e gatos com ansiedade, dor e outras condições. Guias completos de dosagem e segurança.
										</p>
										<span class="mui-button mui-button-text" style="color: var(--mui-blue-primary);">
											Explorar
											<svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-left: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
											</svg>
										</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php endif; ?>
					
					<?php if ( $legislacao_url ) : ?>
					<div class="mui-card mui-card-elevated" style="transition: all 0.3s ease;">
						<a href="<?php echo esc_url( $legislacao_url ); ?>" style="text-decoration: none; display: block;">
							<div class="mui-card-content">
								<div style="display: flex; gap: 16px; align-items: flex-start;">
									<div style="font-size: 48px; flex-shrink: 0;">⚖️</div>
									<div style="flex: 1;">
										<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">
											Monitor de Legislação
										</h3>
										<p class="mui-typography-body2 mb-4" style="color: var(--mui-gray-600);">
											Acompanhe as últimas alterações na legislação portuguesa sobre CBD e cânhamo. Sistema de monitorização automática de fontes oficiais.
										</p>
										<span class="mui-button mui-button-text" style="color: var(--mui-blue-primary);">
											Explorar
											<svg style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-left: 4px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
											</svg>
										</span>
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

	<!-- FAQ Section - MUI Accordion -->
	<section class="faq-section py-16 md:py-20" style="background: var(--mui-gray-50);" id="faq">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						Perguntas Frequentes sobre CBD para Pessoas
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Respostas às questões mais comuns sobre CBD para uso humano
					</p>
				</header>
				
				<?php
				$faqs = array(
					array(
						'question' => 'Qual é a dosagem inicial recomendada de CBD para ansiedade em pessoas?',
						'answer' => 'A dosagem inicial de CBD pode variar significativamente, mas a maioria dos especialistas sugere começar com uma dose baixa de 5mg a 10mg, duas vezes ao dia. É essencial ajustar a dose gradualmente com base na resposta individual. Para ansiedade mais severa, doses de manutenção podem variar entre 10mg e 30mg por dia, divididas em 2-3 administrações. Sempre consulte um médico antes de iniciar o uso de CBD para ansiedade, especialmente se estiver a tomar outros medicamentos.'
					),
					array(
						'question' => 'O CBD é legal para consumo humano em Portugal?',
						'answer' => 'Em Portugal, o CBD é legal desde que o produto final contenha um teor de THC inferior ao limite legal estabelecido (0,2% ou menos) e cumpra os regulamentos do Infarmed. A venda e o consumo de produtos cosméticos e tópicos são permitidos, enquanto produtos para consumo oral requerem autorização do Infarmed. Para uso medicinal, o CBD requer prescrição médica. Consulte o nosso Monitor de Legislação para informações atualizadas sobre alterações na legislação portuguesa sobre CBD.'
					),
					array(
						'question' => 'Como tomar óleo de CBD?',
						'answer' => 'O óleo de CBD é geralmente administrado por via sublingual (debaixo da língua). Coloque a dose recomendada debaixo da língua e mantenha por 30-60 segundos antes de engolir. Esta via de administração permite uma absorção mais rápida através das membranas mucosas. O óleo de CBD também pode ser adicionado a alimentos ou bebidas, embora a absorção seja mais lenta. Comece sempre com a dose mais baixa indicada na embalagem e aumente gradualmente se necessário.'
					),
					array(
						'question' => 'O CBD causa efeitos colaterais?',
						'answer' => 'O CBD é geralmente bem tolerado, mas algumas pessoas podem experimentar efeitos colaterais leves, incluindo sonolência, boca seca, tontura, mudanças no apetite ou diarreia. Estes efeitos são geralmente temporários e diminuem com o uso continuado. O CBD pode interagir com certos medicamentos, incluindo anticoagulantes e antidepressivos, por isso é crucial informar o seu médico sobre o uso de CBD antes de iniciar qualquer tratamento.'
					),
					array(
						'question' => 'Qual a diferença entre CBD e THC?',
						'answer' => 'O CBD (canabidiol) e o THC (tetrahidrocanabinol) são ambos compostos da planta Cannabis sativa, mas têm efeitos muito diferentes. O THC é psicoativo e causa o "high" associado à cannabis, enquanto o CBD não possui efeitos psicoativos e não causa alterações de consciência. Em Portugal, produtos de CBD legais devem conter menos de 0,2% de THC. O CBD interage com o sistema endocanabinoide de forma diferente do THC, oferecendo benefícios terapêuticos sem os efeitos intoxicantes.'
					),
				);
				?>
				
				<div id="faq-accordion-app" class="space-y-4">
					<!-- Accordion será renderizado via Vue -->
				</div>
			</div>
		</div>
	</section>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		function initFAQAccordion() {
			if (typeof Vue === 'undefined') {
				setTimeout(initFAQAccordion, 100);
				return;
			}
			
			const { createApp } = Vue;
			const container = document.getElementById('faq-accordion-app');
			if (!container) return;
			
			const faqs = <?php echo json_encode( $faqs, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?>;
			
			const app = createApp({
				data() {
					return {
						faqs: faqs,
						expandedIndex: null
					};
				},
				methods: {
					toggle(index) {
						this.expandedIndex = this.expandedIndex === index ? null : index;
					}
				},
				template: `
					<div>
						<div v-for="(faq, index) in faqs" :key="index" class="mui-accordion mui-card mui-card-elevated">
							<div 
								:class="['mui-accordion-summary', { 'mui-accordion-summary-expanded': expandedIndex === index }]"
								@click="toggle(index)"
								style="cursor: pointer;"
							>
								<h3 class="mui-typography-subtitle1" style="margin: 0; flex: 1;">{{ faq.question }}</h3>
								<span class="mui-accordion-icon">{{ expandedIndex === index ? '−' : '+' }}</span>
							</div>
							<div v-if="expandedIndex === index" class="mui-accordion-details">
								<p class="mui-typography-body2" style="margin: 0;">{{ faq.answer }}</p>
							</div>
						</div>
					</div>
				`
			});
			app.mount('#faq-accordion-app');
		}
		
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				setTimeout(initFAQAccordion, 300);
			});
		} else {
			setTimeout(initFAQAccordion, 300);
		}
	});
	</script>

	<!-- Schema Markup (JSON-LD) -->
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "FAQPage",
		"@id": "<?php echo esc_url( get_permalink() ); ?>#faqpage",
		"mainEntity": [
			<?php
			$faqs_json = array();
			foreach ( $faqs as $faq ) {
				$faqs_json[] = array(
					'@type' => 'Question',
					'name' => $faq['question'],
					'acceptedAnswer' => array(
						'@type' => 'Answer',
						'text' => $faq['answer']
					)
				);
			}
			echo json_encode( $faqs_json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES );
			?>
		]
	}
	</script>
</main>

<?php
get_footer();
?>
