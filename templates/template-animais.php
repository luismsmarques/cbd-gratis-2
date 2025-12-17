<?php
/**
 * Template Name: CBD para Animais (Página Mãe)
 * 
 * Página hub que encaminha tráfego para páginas filhas (Cães e Gatos)
 * Design MUI focado em rigor, segurança e inovação
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get child pages for Schema.org and URLs
$caes_page = get_page_by_path( 'cbd-para-caes' );
if ( ! $caes_page ) {
	$caes_page = get_page_by_path( 'caes' );
}
if ( ! $caes_page ) {
	$caes_page = get_page_by_path( 'cbd-caes' );
}

$gatos_page = get_page_by_path( 'cbd-para-gatos' );
if ( ! $gatos_page ) {
	$gatos_page = get_page_by_path( 'gatos' );
}
if ( ! $gatos_page ) {
	$gatos_page = get_page_by_path( 'cbd-gatos' );
}

$caes_url = $caes_page ? get_permalink( $caes_page->ID ) : '#';
$gatos_url = $gatos_page ? get_permalink( $gatos_page->ID ) : '#';
$legislacao_url = '';
$legislacao_page = get_page_by_path( 'monitor-legislacao' );
if ( ! $legislacao_page ) {
	$legislacao_page = get_page_by_path( 'legislacao' );
}
if ( $legislacao_page ) {
	$legislacao_url = get_permalink( $legislacao_page->ID );
}
?>

<!-- Hero Section - MUI Design Hub de Triagem -->
<main class="main-content">
	<section class="hero-animais py-12 md:py-20" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.05), var(--mui-gray-50));">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto text-center">
				<!-- Trust Badge - MUI Chip -->
				<div class="mui-chip mui-chip-success mb-6" style="display: inline-flex;">
					<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
				</svg>
					<span>Especialistas em CBD para Animais em Portugal</span>
			</div>
			
				<h1 class="mui-typography-h1 mb-6">
				<?php echo esc_html( cbd_ai_get_animais_h1() ); ?>
			</h1>
			
				<p class="mui-typography-body1 mb-8" style="max-width: 640px; margin-left: auto; margin-right: auto; color: var(--mui-gray-700);">
				Guias completos sobre segurança, dosagem e benefícios do CBD para cães e gatos. Informação validada por veterinários e especialistas.
			</p>
			
				<!-- Condition Keywords (SEO) - MUI Chips -->
				<div class="mui-chips-container" style="justify-content: center;">
					<span class="mui-chip">CBD ansiedade cães</span>
					<span class="mui-chip">CBD dores gatos</span>
					<span class="mui-chip">CBD artrite animais</span>
					<span class="mui-chip">CBD convulsões pets</span>
			</div>
		</div>
	</div>
</section>

	<!-- Safety Definition Section - MUI Alert -->
	<section class="safety-definition-section py-12">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
				<div class="mui-alert mui-alert-info mui-alert-elevated">
					<div class="mui-alert-icon">ℹ</div>
					<div class="mui-alert-message">
						<h2 class="mui-typography-h5 mb-3" style="margin: 0 0 12px 0; font-weight: 600;">Segurança do CBD para Animais</h2>
						<p class="mui-typography-body1" style="margin: 0;">
					O CBD é geralmente bem tolerado por cães e gatos, mas requer atenção especial à dosagem, especialmente em felinos, devido ao seu metabolismo hepático único. Sempre consulte um veterinário antes de iniciar qualquer tratamento com CBD para garantir a segurança e eficácia adequadas.
				</p>
			</div>
				</div>
			</div>
		</div>
	</section>

	<!-- ActionCards Section - Cães e Gatos -->
	<section class="action-cards-section py-16 md:py-20">
		<div class="container mx-auto px-4">
			<div id="animais-action-cards-app" class="grid grid-cols-1 md:grid-cols-2 gap-8" style="max-width: 1200px; margin-left: auto; margin-right: auto;">
				<!-- ActionCards serão renderizados via Vue -->
		</div>
	</div>
</section>

	<!-- Comparison Table Section - MUI Table -->
	<section class="comparison-section py-16 md:py-20" style="background: var(--mui-gray-50);">
	<div class="container mx-auto px-4">
		<div class="max-w-5xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					CBD para Cães vs. CBD para Gatos: Diferenças Chave
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					Comparação detalhada para ajudar a escolher o melhor produto para o seu animal de estimação
				</p>
			</header>
			
				<!-- Comparison Table - MUI Table -->
				<div class="mui-card mui-card-elevated mb-6">
					<div class="mui-table-container">
						<table class="mui-table">
							<thead>
							<tr>
									<th class="mui-table-head">Característica</th>
									<th class="mui-table-head" style="text-align: center;">
										<span style="display: inline-flex; align-items: center; gap: 8px;">
										🐕 CBD para Cães
									</span>
								</th>
									<th class="mui-table-head" style="text-align: center;">
										<span style="display: inline-flex; align-items: center; gap: 8px;">
										🐱 CBD para Gatos
									</span>
								</th>
							</tr>
						</thead>
							<tbody>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">Metabolismo</td>
									<td class="mui-table-cell" style="text-align: center;">Metaboliza CBD mais rapidamente</td>
									<td class="mui-table-cell" style="text-align: center;">Metabolismo hepático mais lento e sensível</td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">Sensibilidade ao THC</td>
									<td class="mui-table-cell" style="text-align: center;">Geralmente tolera melhor pequenas quantidades</td>
									<td class="mui-table-cell" style="text-align: center;">Extremamente sensível, requer produtos sem THC</td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">Dosagem Recomendada</td>
									<td class="mui-table-cell" style="text-align: center;">0,1-0,5 mg/kg de peso corporal, 2x ao dia</td>
									<td class="mui-table-cell" style="text-align: center;">0,05-0,25 mg/kg de peso corporal, 2x ao dia</td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">Formatos Recomendados</td>
									<td class="mui-table-cell" style="text-align: center;">Óleo sublingual, petiscos, cápsulas</td>
									<td class="mui-table-cell" style="text-align: center;">Óleo sublingual, pasta oral, gotas sem sabor</td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">Concentração Ideal</td>
									<td class="mui-table-cell" style="text-align: center;">150-300 mg por frasco (30ml)</td>
									<td class="mui-table-cell" style="text-align: center;">75-150 mg por frasco (30ml)</td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">Tempo de Efeito</td>
									<td class="mui-table-cell" style="text-align: center;">30-60 minutos</td>
									<td class="mui-table-cell" style="text-align: center;">20-45 minutos</td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">Condições Mais Comuns</td>
									<td class="mui-table-cell" style="text-align: center;">Ansiedade, artrite, epilepsia, dor crônica</td>
									<td class="mui-table-cell" style="text-align: center;">Ansiedade, dor, inflamação, problemas digestivos</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
				<!-- Table Source/Disclaimer - MUI Alert -->
				<div class="mui-alert mui-alert-warning">
					<div class="mui-alert-icon">⚠</div>
					<div class="mui-alert-message">
						<p class="mui-typography-caption" style="margin: 0;">
					<strong>Nota:</strong> Estas são diretrizes gerais. Sempre consulte um veterinário antes de administrar CBD ao seu animal de estimação. As dosagens podem variar conforme a condição, peso e sensibilidade individual.
				</p>
					</div>
			</div>
		</div>
	</div>
</section>

	<!-- Benefits List Section - MUI Cards -->
	<section class="benefits-section py-16 md:py-20">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					Benefícios Comuns do CBD para Animais
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					O CBD pode ajudar em diversas condições de saúde em cães e gatos
				</p>
			</header>
			
				<div class="mui-card mui-card-elevated">
					<div class="mui-card-content">
						<ol class="mui-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 24px;">
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(0, 137, 123, 0.12); color: var(--mui-teal-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.125rem;">1</span>
								<div style="flex: 1;">
									<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 8px;">Ansiedade e Stress:</strong>
									<p class="mui-typography-body1" style="margin: 0;">Reduz ansiedade de separação, fobias (fogos de artifício, tempestades) e stress em situações como viagens ou visitas ao veterinário.</p>
						</div>
					</li>
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(0, 137, 123, 0.12); color: var(--mui-teal-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.125rem;">2</span>
								<div style="flex: 1;">
									<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 8px;">Dor e Inflamação:</strong>
									<p class="mui-typography-body1" style="margin: 0;">Eficaz no alívio de dores crônicas, artrite, inflamações articulares e desconforto pós-cirúrgico em animais idosos ou com lesões.</p>
						</div>
					</li>
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(0, 137, 123, 0.12); color: var(--mui-teal-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.125rem;">3</span>
								<div style="flex: 1;">
									<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 8px;">Epilepsia e Convulsões:</strong>
									<p class="mui-typography-body1" style="margin: 0;">Estudos veterinários mostram redução significativa na frequência e intensidade de convulsões epiléticas em cães e gatos.</p>
						</div>
					</li>
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(0, 137, 123, 0.12); color: var(--mui-teal-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.125rem;">4</span>
								<div style="flex: 1;">
									<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 8px;">Problemas Digestivos:</strong>
									<p class="mui-typography-body1" style="margin: 0;">Ajuda a regular o apetite, reduzir náuseas, melhorar problemas digestivos e aliviar sintomas de síndrome do intestino irritável.</p>
						</div>
					</li>
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(0, 137, 123, 0.12); color: var(--mui-teal-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.125rem;">5</span>
								<div style="flex: 1;">
									<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 8px;">Bem-estar Geral:</strong>
									<p class="mui-typography-body1" style="margin: 0;">Melhora a qualidade de vida, promove relaxamento, melhora o sono e pode ajudar em comportamentos agressivos ou compulsivos.</p>
						</div>
					</li>
				</ol>
					</div>
			</div>
		</div>
	</div>
</section>

	<!-- Legal Alert Section - MUI Alert -->
	<section class="legal-alert-section py-12" style="background: var(--mui-gray-50);">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
				<?php if ( $legislacao_url ) : ?>
				<div class="mui-alert mui-alert-warning mui-alert-elevated">
					<div class="mui-alert-icon">⚠</div>
					<div class="mui-alert-message">
						<h3 class="mui-typography-h6 mb-3" style="margin: 0 0 12px 0; font-weight: 600;">Status Legal do CBD para Uso Veterinário em Portugal</h3>
						<p class="mui-typography-body1 mb-4" style="margin: 0 0 16px 0;">
							O CBD para uso veterinário é permitido em Portugal? Verifique o status legal atual no nosso <a href="<?php echo esc_url( $legislacao_url ); ?>" class="mui-button mui-button-text" style="color: var(--mui-blue-primary);">Monitor de Legislação</a>, que acompanha automaticamente as alterações na legislação portuguesa e europeia sobre CBD e cannabis medicinal.
						</p>
						<a href="<?php echo esc_url( $legislacao_url ); ?>" class="mui-button mui-button-outlined mui-button-primary" style="display: inline-flex; align-items: center; gap: 8px;">
							Ver status legal atual
							<svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
							</svg>
						</a>
					</div>
				</div>
				<?php endif; ?>
		</div>
	</div>
</section>

	<!-- Strategic Internal Links Section - MUI Cards -->
	<section class="links-section py-16 md:py-20">
	<div class="container mx-auto px-4">
		<div class="max-w-6xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					Guias Especializados por Tipo de Animal
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					Explore nossos guias completos e detalhados para cada tipo de animal de estimação
				</p>
			</header>
			
			<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
				<?php
				$child_pages = cbd_ai_get_animais_child_pages();
				foreach ( $child_pages as $index => $page ) :
					$is_caes = ( strpos( strtolower( $page['title'] ), 'cão' ) !== false || strpos( strtolower( $page['title'] ), 'caes' ) !== false );
				?>
						<div class="mui-card mui-card-elevated" style="transition: all 0.3s ease;">
							<a href="<?php echo esc_url( $page['url'] ); ?>" style="text-decoration: none; display: block;">
								<div class="mui-card-content">
									<div style="display: flex; gap: 16px; align-items: flex-start;">
										<div style="width: 64px; height: 64px; background-color: rgba(0, 137, 123, 0.12); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 32px;">
											<?php echo esc_html( $page['icon'] ); ?>
								</div>
										<div style="flex: 1;">
											<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">
										<?php echo esc_html( $page['title'] ); ?>
									</h3>
											<p class="mui-typography-caption mb-3" style="color: var(--mui-gray-600);">
										<?php echo esc_html( $page['subtitle'] ); ?>
									</p>
											<p class="mui-typography-body2 mb-4" style="color: var(--mui-gray-700);">
								<?php echo esc_html( $page['description'] ); ?>
							</p>
							<?php if ( $is_caes ) : ?>
												<span class="mui-button mui-button-contained mui-button-primary" style="display: inline-flex; align-items: center; gap: 8px;">
									Consulte o nosso guia detalhado de Dosagem de CBD para Cães por peso
													<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
									</svg>
												</span>
							<?php else : ?>
												<span class="mui-button mui-button-contained mui-button-primary" style="display: inline-flex; align-items: center; gap: 8px;">
									Veja os avisos de segurança específicos para CBD para Gatos
													<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
									</svg>
												</span>
							<?php endif; ?>
						</div>
									</div>
								</div>
							</a>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

	<!-- Product Format Section - MUI Cards Grid -->
	<section class="product-format-section py-16 md:py-20" style="background: var(--mui-gray-50);">
	<div class="container mx-auto px-4">
		<div class="max-w-6xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					Formato do Produto: Escolha o Melhor para o Seu Animal
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					Existem diferentes formatos de CBD disponíveis para animais de estimação
				</p>
			</header>
			
				<div id="product-formats-grid">
				<!-- Format 1: Óleo -->
					<div class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h6 mb-3" style="font-weight: 600;">Óleo de CBD</h3>
							<p class="mui-typography-body2" style="margin: 0;">
								O formato mais comum e versátil. Pode ser administrado diretamente na boca ou misturado com comida. Ideal para <a href="<?php echo esc_url( $caes_url ); ?>" class="mui-button mui-button-text" style="color: var(--mui-teal-primary);">dosagem precisa em cães</a> e <a href="<?php echo esc_url( $gatos_url ); ?>" class="mui-button mui-button-text" style="color: var(--mui-teal-primary);">administração cuidadosa em gatos</a>.
					</p>
						</div>
				</div>
				
				<!-- Format 2: Petiscos -->
					<div class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h6 mb-3" style="font-weight: 600;">Petiscos e Guloseimas</h3>
							<p class="mui-typography-body2" style="margin: 0;">
								Mais fácil de administrar, especialmente para animais que não gostam do sabor do óleo. Disponível principalmente para cães. Consulte o nosso <a href="<?php echo esc_url( $caes_url ); ?>" class="mui-button mui-button-text" style="color: var(--mui-teal-primary);">guia completo de CBD para cães</a> para mais informações.
					</p>
						</div>
				</div>
				
				<!-- Format 3: Cápsulas -->
					<div class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h6 mb-3" style="font-weight: 600;">Cápsulas</h3>
							<p class="mui-typography-body2" style="margin: 0;">
						Ideal para animais que precisam de doses consistentes e não têm problemas em engolir comprimidos. Mais comum para cães de médio e grande porte.
					</p>
						</div>
				</div>
			</div>
		</div>
	</div>
</section>

	<!-- Common Conditions Section - MUI Cards Grid -->
	<section class="conditions-section py-16 md:py-20">
	<div class="container mx-auto px-4">
		<div class="max-w-6xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					Condições Comuns Tratadas com CBD em Animais
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					O CBD pode ajudar em diversas condições de saúde em cães e gatos
				</p>
			</header>
			
				<div id="conditions-grid">
				<?php
				$conditions = array(
					array(
						'title' => 'Ansiedade e Stress',
						'keywords' => 'CBD ansiedade cães, CBD stress gatos',
						'description' => 'Ajuda a reduzir ansiedade de separação, fobias e stress em situações como viagens ou fogos de artifício.',
						'icon' => '😰'
					),
					array(
						'title' => 'Dor e Inflamação',
						'keywords' => 'CBD dores gatos, CBD artrite cães',
						'description' => 'Eficaz no alívio de dores crônicas, artrite e inflamações articulares em animais idosos.',
						'icon' => '🦴'
					),
					array(
						'title' => 'Epilepsia e Convulsões',
						'keywords' => 'CBD convulsões animais, CBD epilepsia pets',
						'description' => 'Estudos mostram redução significativa na frequência e intensidade de convulsões epiléticas.',
						'icon' => '⚡'
					),
					array(
						'title' => 'Problemas Digestivos',
						'keywords' => 'CBD digestão gatos, CBD náusea animais',
						'description' => 'Ajuda a regular o apetite, reduzir náuseas e melhorar problemas digestivos.',
						'icon' => '🍽️'
					),
					array(
						'title' => 'Problemas de Pele',
						'keywords' => 'CBD pele animais, CBD alergias pets',
						'description' => 'Aplicação tópica pode ajudar em alergias, dermatites e problemas de pele.',
						'icon' => '🦠'
					),
					array(
						'title' => 'Comportamento',
						'keywords' => 'CBD comportamento animais, CBD agressividade pets',
						'description' => 'Pode ajudar a reduzir comportamentos agressivos e melhorar o bem-estar geral.',
						'icon' => '🐾'
					),
				);
				
				foreach ( $conditions as $condition ) :
				?>
						<div class="mui-card mui-card-elevated">
							<div class="mui-card-content">
								<div style="font-size: 48px; margin-bottom: 16px;"><?php echo esc_html( $condition['icon'] ); ?></div>
								<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">
							<?php echo esc_html( $condition['title'] ); ?>
						</h3>
								<p class="mui-typography-body2 mb-3" style="margin: 0 0 12px 0;">
							<?php echo esc_html( $condition['description'] ); ?>
						</p>
								<p class="mui-typography-caption" style="margin: 0; color: var(--mui-gray-500);">
							<strong>Palavras-chave:</strong> <?php echo esc_html( $condition['keywords'] ); ?>
						</p>
							</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- Schema.org CollectionPage and FAQPage -->
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@graph": [
		{
			"@type": "CollectionPage",
			"@id": "<?php echo esc_url( get_permalink() ); ?>#collectionpage",
			"name": "Guias e Informação sobre CBD para Animais de Estimação",
			"description": "O hub de autoridade em CBD para cães e gatos em Portugal. Encontre dosagem segura, benefícios e avisos veterinários.",
			"url": "<?php echo esc_url( get_permalink() ); ?>",
			"mainEntity": [
				<?php if ( $caes_page ) : ?>
				{
					"@type": "WebPage",
					"url": "<?php echo esc_url( get_permalink( $caes_page->ID ) ); ?>",
					"name": "CBD para Cães"
				}<?php if ( $gatos_page ) : ?>,<?php endif; ?>
				<?php endif; ?>
				<?php if ( $gatos_page ) : ?>
				{
					"@type": "WebPage",
					"url": "<?php echo esc_url( get_permalink( $gatos_page->ID ) ); ?>",
					"name": "CBD para Gatos"
				}
				<?php endif; ?>
			]
		},
		{
			"@type": "FAQPage",
			"@id": "<?php echo esc_url( get_permalink() ); ?>#faqpage",
			"mainEntity": [
				{
					"@type": "Question",
					"name": "Qual a diferença entre óleo de CBD e óleo de cânhamo para pets?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "O óleo de CBD contém canabidiol isolado ou em concentração elevada, enquanto o óleo de cânhamo é extraído das sementes e contém apenas traços de CBD. Para efeitos terapêuticos em animais, o óleo de CBD é mais eficaz. O óleo de cânhamo é principalmente nutricional."
					}
				},
				{
					"@type": "Question",
					"name": "O CBD é seguro para todos os animais de estimação?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "O CBD é geralmente bem tolerado por cães e gatos quando administrado corretamente. No entanto, gatos são mais sensíveis devido ao seu metabolismo hepático único e requerem doses menores. Sempre consulte um veterinário antes de iniciar qualquer tratamento com CBD."
					}
				},
				{
					"@type": "Question",
					"name": "Como calcular a dosagem correta de CBD para o meu animal?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "A dosagem varia conforme o peso, condição e sensibilidade do animal. Para cães, geralmente recomenda-se 0,1-0,5 mg/kg de peso corporal, 2x ao dia. Para gatos, a dose é menor: 0,05-0,25 mg/kg, 2x ao dia. Consulte o nosso guia detalhado de dosagem de CBD para cães por peso ou veja os avisos de segurança específicos para CBD para gatos."
					}
				},
				{
					"@type": "Question",
					"name": "O CBD pode interagir com outros medicamentos veterinários?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "Sim, o CBD pode interagir com certos medicamentos veterinários, especialmente aqueles metabolizados pelo fígado. É crucial informar o seu veterinário sobre o uso de CBD antes de iniciar ou alterar qualquer medicação. O veterinário pode ajustar as doses ou monitorar possíveis interações."
					}
				}
			]
		}
	]
}
</script>

	<?php
	// Enqueue ActionCard component
	wp_enqueue_script(
		'cbd-ai-action-card',
		CBD_AI_THEME_URI . '/assets/js/components/ActionCard.js',
		array( 'vue-prod' ),
		CBD_AI_THEME_VERSION,
		false
	);
	?>

	<script>
	document.addEventListener('DOMContentLoaded', function() {
		function initAnimaisActionCards() {
			// Check if Vue Helper is available
			if (typeof window.CBDVueHelper === 'undefined') {
				setTimeout(initAnimaisActionCards, 100);
				return;
			}
			
			const caes_url = '<?php 
				$caes_page = get_page_by_path( 'cbd-para-caes' );
				if ( ! $caes_page ) {
					$caes_page = get_page_by_path( 'cbd-animais/cbd-para-caes' );
				}
				echo esc_js( $caes_page ? get_permalink( $caes_page->ID ) : home_url( '/cbd-para-caes/' ) );
			?>';
			
			const gatos_url = '<?php 
				$gatos_page = get_page_by_path( 'cbd-para-gatos' );
				if ( ! $gatos_page ) {
					$gatos_page = get_page_by_path( 'cbd-animais/cbd-para-gatos' );
				}
				echo esc_js( $gatos_page ? get_permalink( $gatos_page->ID ) : home_url( '/cbd-para-gatos/' ) );
			?>';
			
			// Initialize ActionCards using Vue Helper
			window.CBDVueHelper.initComponent('ActionCard', 'animais-action-cards-app', {
				template: `
					<ActionCard 
						titulo="CBD para Cães"
						descricao="O guia definitivo de dosagem por peso, segurança veterinária e benefícios do CBD para cães."
						icone="🐕"
						:url="caes_url"
						cor="teal"
						tamanho="large"
					/>
					<ActionCard 
						titulo="CBD para Gatos"
						descricao="Guia veterinário de dosagem segura e produtos sem THC para gatos."
						icone="🐱"
						:url="gatos_url"
						cor="primary"
						tamanho="large"
					/>
				`,
				data() {
					return {
						caes_url: caes_url,
						gatos_url: gatos_url
					};
				}
			});
		}
		
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				setTimeout(initAnimaisActionCards, 300);
			});
		} else {
			setTimeout(initAnimaisActionCards, 300);
		}
	});
	</script>
</main>

<?php
get_footer();
?>
