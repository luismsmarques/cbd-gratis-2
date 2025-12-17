<?php
/**
 * Template Name: CBD para Cães
 * 
 * Página especializada em CBD para cães
 * Design MUI focado em rigor clínico e segurança veterinária
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get related pages for internal links
$gatos_page = get_page_by_path( 'cbd-para-gatos' );
if ( ! $gatos_page ) {
	$gatos_page = get_page_by_path( 'gatos' );
}
if ( ! $gatos_page ) {
	$gatos_page = get_page_by_path( 'cbd-gatos' );
}

$legislacao_page = get_page_by_path( 'monitor-legislacao' );
if ( ! $legislacao_page ) {
	$legislacao_page = get_page_by_path( 'legislacao' );
}
?>

<!-- Hero Section - MUI Design Guia Clínico -->
<main class="main-content">
	<section class="hero-caes py-12 md:py-20" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(0, 137, 123, 0.05), var(--mui-gray-50));">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto text-center">
				<!-- Trust Badge - MUI Chip -->
				<div class="mui-chip mui-chip-success mb-6" style="display: inline-flex;">
					<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
				</svg>
					<span>Especialistas em CBD para Cães em Portugal</span>
			</div>
			
				<h1 class="mui-typography-h1 mb-6">
				<?php echo esc_html( cbd_ai_get_caes_h1() ); ?>
			</h1>
			
				<p class="mui-typography-body1 mb-8" style="max-width: 640px; margin-left: auto; margin-right: auto; color: var(--mui-gray-700);">
				O guia definitivo sobre CBD para cães em Portugal. Aprenda a calcular a dosagem correta por peso, descubra os benefícios para ansiedade, artrite e epilepsia, e garanta a segurança do seu melhor amigo.
			</p>
			
				<!-- Condition Keywords (SEO) - MUI Chips -->
				<div class="mui-chips-container" style="justify-content: center;">
					<span class="mui-chip">dosagem cbd cão</span>
					<span class="mui-chip">CBD ansiedade canina</span>
					<span class="mui-chip">CBD artrite cães</span>
					<span class="mui-chip">CBD epilepsia cães</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Tabs Section - MUI Tabs para organizar conteúdo -->
	<section class="tabs-section py-16 md:py-20">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<!-- MUI Tabs -->
				<div id="caes-tabs-app">
					<!-- Tabs serão renderizados via Vue -->
			</div>
		</div>
	</div>
</section>

	<!-- Dosage Table Section - MUI Table Style (Tab 1 Content) -->
	<section class="dosage-table-section py-16 md:py-20" style="background: var(--mui-gray-50); display: none;" id="dosagem-tab-content">
	<div class="container mx-auto px-4">
		<div class="max-w-6xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					Tabela de Dosagem de CBD para Cães por Peso e Condição
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					Use esta tabela para calcular a dose correta de CBD com base no peso do seu cão e na gravidade da condição
				</p>
			</header>
			
				<!-- Dosage Table - MUI Table -->
				<div class="mui-card mui-card-elevated mb-8">
					<div class="mui-table-container">
						<table class="mui-table">
							<thead>
							<tr>
									<th class="mui-table-head">Peso do Cão (kg)</th>
									<th class="mui-table-head" style="text-align: center;">Condição Ligeira</th>
									<th class="mui-table-head" style="text-align: center;">Condição Moderada</th>
									<th class="mui-table-head" style="text-align: center;">Condição Crónica</th>
							</tr>
						</thead>
							<tbody>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">2-5 kg</td>
									<td class="mui-table-cell" style="text-align: center;">0,5-1 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">1-2 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">2-3 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2-3x ao dia</span></td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">5-10 kg</td>
									<td class="mui-table-cell" style="text-align: center;">1-2 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">2-4 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">4-6 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2-3x ao dia</span></td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">10-20 kg</td>
									<td class="mui-table-cell" style="text-align: center;">2-5 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">5-10 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">10-15 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2-3x ao dia</span></td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">20-30 kg</td>
									<td class="mui-table-cell" style="text-align: center;">5-10 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">10-15 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">15-25 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2-3x ao dia</span></td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">30-40 kg</td>
									<td class="mui-table-cell" style="text-align: center;">10-15 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">15-20 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">20-30 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2-3x ao dia</span></td>
							</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">40+ kg</td>
									<td class="mui-table-cell" style="text-align: center;">15-20 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">20-30 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">30-40 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2-3x ao dia</span></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
				<!-- Table Disclaimer - MUI Alert -->
				<div class="mui-alert mui-alert-warning">
					<div class="mui-alert-icon">⚠</div>
					<div class="mui-alert-message">
						<h3 class="mui-typography-h6 mb-3" style="margin: 0 0 12px 0; font-weight: 600;">Importante sobre a Dosagem</h3>
						<div class="mui-typography-body2" style="margin: 0;">
							<p style="margin: 0 0 8px 0;"><strong>Condição Ligeira:</strong> Ansiedade leve, stress ocasional, desconforto menor.</p>
							<p style="margin: 0 0 8px 0;"><strong>Condição Moderada:</strong> Ansiedade moderada, dor crônica leve, inflamação persistente.</p>
							<p style="margin: 0 0 8px 0;"><strong>Condição Crónica:</strong> Epilepsia, artrite severa, ansiedade severa, dor crônica intensa.</p>
							<p style="margin: 0;"><strong>Sempre comece com a dose mais baixa</strong> e aumente gradualmente conforme necessário. Consulte sempre um veterinário antes de iniciar qualquer tratamento com CBD.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Segurança Tab Content - MUI Card -->
	<section class="seguranca-tab-content py-16 md:py-20" style="background: var(--mui-gray-50); display: none;" id="seguranca-tab-content">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">Segurança do CBD para Cães</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Informações essenciais sobre segurança e precauções ao usar CBD com cães
					</p>
				</header>
				
				<div class="mui-card mui-card-elevated">
					<div class="mui-card-content">
						<div class="mui-typography-body1" style="line-height: 1.75;">
							<p class="mb-4">O CBD é geralmente bem tolerado por cães quando administrado corretamente. Sempre consulte um veterinário antes de iniciar qualquer tratamento.</p>
							
							<h3 class="mui-typography-h6 mb-3" style="font-weight: 600; margin-top: 24px;">Precauções Importantes:</h3>
							<ul class="mui-list" style="list-style: none; padding: 0; margin: 0 0 24px 0;">
								<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 12px;">
									<span style="color: var(--mui-teal-primary);">✓</span>
									<span>Use apenas produtos de CBD específicos para animais ou óleos puros sem aditivos</span>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 12px;">
									<span style="color: var(--mui-teal-primary);">✓</span>
									<span>Evite produtos com xilitol, que é tóxico para cães</span>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 12px;">
									<span style="color: var(--mui-teal-primary);">✓</span>
									<span>Comece sempre com a dose mais baixa e aumente gradualmente</span>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px;">
									<span style="color: var(--mui-teal-primary);">✓</span>
									<span>Informe o seu veterinário sobre o uso de CBD, especialmente se o cão toma outros medicamentos</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Condições Tab Content - MUI Cards Grid -->
	<section class="condicoes-tab-content py-16 md:py-20" style="background: var(--mui-gray-50); display: none;" id="condicoes-tab-content">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">Condições Tratadas com CBD</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						O CBD pode ajudar em diversas condições de saúde em cães
					</p>
				</header>
				
				<div id="condicoes-grid">
					<div class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<div style="font-size: 48px; margin-bottom: 16px;">😰</div>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Ansiedade e Stress</h3>
							<p class="mui-typography-body2" style="margin: 0;">Reduz ansiedade de separação, fobias e stress em situações como viagens ou visitas ao veterinário.</p>
						</div>
					</div>
					
					<div class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<div style="font-size: 48px; margin-bottom: 16px;">🦴</div>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Dor e Inflamação</h3>
							<p class="mui-typography-body2" style="margin: 0;">Eficaz no alívio de dores crônicas, artrite e inflamações articulares em animais idosos.</p>
						</div>
					</div>
					
					<div class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<div style="font-size: 48px; margin-bottom: 16px;">⚡</div>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Epilepsia e Convulsões</h3>
							<p class="mui-typography-body2" style="margin: 0;">Estudos mostram redução significativa na frequência e intensidade de convulsões epiléticas.</p>
						</div>
					</div>
					
					<div class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<div style="font-size: 48px; margin-bottom: 16px;">🍽️</div>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Problemas Digestivos</h3>
							<p class="mui-typography-body2" style="margin: 0;">Ajuda a regular o apetite, reduzir náuseas e melhorar problemas digestivos.</p>
						</div>
					</div>
			</div>
		</div>
	</div>
</section>

	<!-- How To Section - MUI Cards -->
	<section class="howto-section py-16 md:py-20" itemscope itemtype="https://schema.org/HowTo">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4" itemprop="name">
					Como Administrar Óleo de CBD ao Seu Cão em 5 Passos
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);" itemprop="description">
					Instruções seguras e eficazes para dar a dose correta de CBD ao seu cão
				</p>
			</header>
			
				<div class="mui-card mui-card-elevated">
					<div class="mui-card-content">
						<ol class="mui-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 32px;" itemprop="step" itemscope itemtype="https://schema.org/HowToStep">
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 48px; height: 48px; background-color: var(--mui-teal-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">1</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;" itemprop="name">Calcular a Dose</h3>
									<p class="mui-typography-body1" style="margin: 0;" itemprop="text">
										Use a nossa <a href="#dosagem" class="mui-button mui-button-text" style="color: var(--mui-teal-primary);">tabela de dosagem</a> para calcular os miligramas de CBD com base no peso do seu cão e na gravidade da condição. Sempre comece com a dose mais baixa recomendada para o peso do seu cão.
							</p>
						</div>
					</li>
					
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 48px; height: 48px; background-color: var(--mui-teal-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">2</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;" itemprop="name">Medir a Quantidade</h3>
									<p class="mui-typography-body1" style="margin: 0;" itemprop="text">
								Utilize o conta-gotas que vem com o frasco de óleo de CBD para medir a quantidade exata necessária. Verifique a concentração do produto (mg de CBD por ml) e calcule quantas gotas equivalem à dose desejada. <strong>Nunca administre mais do que a dose máxima recomendada.</strong>
							</p>
						</div>
					</li>
					
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 48px; height: 48px; background-color: var(--mui-teal-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">3</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;" itemprop="name">Administrar o Óleo</h3>
									<p class="mui-typography-body1" style="margin: 0;" itemprop="text">
								Levante suavemente o focinho do seu cão e administre o óleo diretamente na boca, debaixo da língua (sublingual) ou na parte interna da bochecha. Alternativamente, pode misturar o óleo com a comida favorita do seu cão, embora a absorção sublingual seja mais eficaz.
							</p>
						</div>
					</li>
					
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 48px; height: 48px; background-color: var(--mui-teal-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">4</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;" itemprop="name">Observar a Reação</h3>
									<p class="mui-typography-body1" style="margin: 0;" itemprop="text">
								Monitore o seu cão durante as primeiras horas após a administração. Observe sinais de melhoria (redução de ansiedade, alívio de dor) ou possíveis efeitos colaterais (sonolência excessiva, boca seca). Mantenha um registo das reações para ajustar a dosagem se necessário.
							</p>
						</div>
					</li>
					
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 48px; height: 48px; background-color: var(--mui-teal-primary); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">5</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;" itemprop="name">Ajustar Conforme Necessário</h3>
									<p class="mui-typography-body1" style="margin: 0;" itemprop="text">
								Após 3-5 dias de uso consistente, avalie a eficácia. Se não houver melhoria significativa e não houver efeitos colaterais, pode aumentar gradualmente a dose em pequenos incrementos (10-20%). Se notar efeitos colaterais, reduza a dose ou consulte um veterinário.
							</p>
						</div>
					</li>
				</ol>
				
				<!-- Tools Required -->
						<div style="margin-top: 32px; padding-top: 32px; border-top: 1px solid var(--mui-gray-200);">
							<h4 class="mui-typography-h6 mb-4" style="font-weight: 600;">Ferramentas Necessárias:</h4>
							<div class="mui-chips-container">
								<span class="mui-chip" itemprop="tool" itemscope itemtype="https://schema.org/HowToTool">
							<span itemprop="name">Óleo de CBD de espectro largo</span>
								</span>
								<span class="mui-chip" itemprop="tool" itemscope itemtype="https://schema.org/HowToTool">
							<span itemprop="name">Tabela de Dosagem</span>
								</span>
								<span class="mui-chip" itemprop="tool" itemscope itemtype="https://schema.org/HowToTool">
							<span itemprop="name">Conta-gotas incluído</span>
								</span>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</section>

	<!-- Condition-Specific Sections - MUI Cards -->
	<section class="conditions-specific-section py-16 md:py-20" style="background: var(--mui-gray-50);">
	<div class="container mx-auto px-4">
		<div class="max-w-6xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					CBD para Condições Específicas em Cães
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					Guias detalhados sobre como usar CBD para as condições mais comuns em cães
				</p>
			</header>
			
				<div style="display: flex; flex-direction: column; gap: 24px;">
				<!-- Condition 1: Anxiety -->
					<article class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h4 mb-4" style="font-weight: 600;">
						CBD para Ansiedade Canina
					</h3>
							<div class="mui-typography-body1" style="line-height: 1.75;">
								<p class="mb-4">
							A ansiedade em cães pode manifestar-se de várias formas: ansiedade de separação, fobias (fogos de artifício, tempestades), ansiedade social ou ansiedade geral. O CBD pode ajudar a reduzir os níveis de stress e promover um estado de calma.
						</p>
								<h4 class="mui-typography-h6 mb-3" style="font-weight: 600; margin-top: 24px;">Dosagem para Ansiedade:</h4>
								<ul class="mui-list" style="list-style: none; padding: 0; margin: 0 0 16px 0;">
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Ansiedade Ligeira:</strong> Use a dose mínima da tabela de dosagem para o peso do seu cão</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Ansiedade Moderada:</strong> Use a dose média recomendada</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Ansiedade Severa:</strong> Consulte um veterinário para doses mais altas, sempre sob supervisão</span>
									</li>
						</ul>
								<div class="mui-alert mui-alert-info" style="margin-top: 16px;">
									<div class="mui-alert-icon">💡</div>
									<div class="mui-alert-message">
										<p class="mui-typography-body2" style="margin: 0;"><strong>Dica:</strong> Para ansiedade relacionada com eventos específicos (fogos de artifício, viagens), administre o CBD 30-60 minutos antes do evento previsto.</p>
									</div>
								</div>
							</div>
					</div>
				</article>
				
				<!-- Condition 2: Joint Pain -->
					<article class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h4 mb-4" style="font-weight: 600;">
						CBD para Dores Articulares e Artrite em Cães
					</h3>
							<div class="mui-typography-body1" style="line-height: 1.75;">
								<p class="mb-4">
							A artrite e as dores articulares são comuns em cães idosos ou com excesso de peso. O CBD possui propriedades anti-inflamatórias e analgésicas que podem ajudar a reduzir a dor e melhorar a mobilidade.
						</p>
								<h4 class="mui-typography-h6 mb-3" style="font-weight: 600; margin-top: 24px;">Dosagem para Dores Articulares:</h4>
								<ul class="mui-list" style="list-style: none; padding: 0; margin: 0 0 16px 0;">
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Dor Ligeira:</strong> Comece com a dose mínima e aumente gradualmente</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Dor Crónica Moderada:</strong> Use a dose média da tabela de dosagem</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Artrite Severa:</strong> Pode necessitar de doses mais altas (condição crónica), sempre com acompanhamento veterinário</span>
									</li>
						</ul>
								<div class="mui-alert mui-alert-info" style="margin-top: 16px;">
									<div class="mui-alert-icon">ℹ</div>
									<div class="mui-alert-message">
										<p class="mui-typography-body2" style="margin: 0;"><strong>Nota:</strong> O efeito pode levar alguns dias a semanas para ser notado. Seja consistente na administração e mantenha um registo da melhoria da mobilidade do seu cão.</p>
									</div>
								</div>
							</div>
					</div>
				</article>
				
				<!-- Condition 3: Epilepsy -->
					<article class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h4 mb-4" style="font-weight: 600;">
						CBD para Epilepsia e Convulsões em Cães
					</h3>
							<div class="mui-typography-body1" style="line-height: 1.75;">
								<p class="mb-4">
							Estudos veterinários demonstraram que o CBD pode reduzir significativamente a frequência e intensidade de convulsões epiléticas em cães. O CBD é frequentemente usado como tratamento complementar aos medicamentos tradicionais.
						</p>
								<h4 class="mui-typography-h6 mb-3" style="font-weight: 600; margin-top: 24px;">Dosagem para Epilepsia:</h4>
								<ul class="mui-list" style="list-style: none; padding: 0; margin: 0 0 16px 0;">
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Tratamento Complementar:</strong> Geralmente requer doses mais altas (condição crónica)</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Supervisão Veterinária:</strong> É essencial trabalhar com um veterinário para ajustar a dose e monitorizar interações com outros medicamentos</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Consistência:</strong> A administração deve ser consistente, geralmente 2-3 vezes ao dia</span>
									</li>
						</ul>
								<div class="mui-alert mui-alert-error">
									<div class="mui-alert-icon">⚠</div>
									<div class="mui-alert-message">
										<p class="mui-typography-body2" style="margin: 0;"><strong>Aviso Importante:</strong> Nunca interrompa abruptamente os medicamentos antiepilépticos do seu cão sem consultar um veterinário. O CBD deve ser usado como complemento, não como substituto.</p>
									</div>
								</div>
						</div>
					</div>
				</article>
			</div>
		</div>
	</div>
</section>

	<!-- Myths and Safety Section - MUI Cards -->
	<section class="myths-safety-section py-16 md:py-20">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					5 Mitos Comuns sobre Cannabis para Cães
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					Desmistificando informações incorretas sobre CBD e cannabis para animais
				</p>
			</header>
			
				<div class="mui-card mui-card-elevated">
					<div class="mui-card-content">
						<ol class="mui-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 32px;">
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(244, 67, 54, 0.12); color: var(--mui-error); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">✗</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Mito: "CBD vai deixar o meu cão 'chapado'"</h3>
									<p class="mui-typography-body1" style="margin: 0;">
								<strong>Verdade:</strong> O CBD não contém THC (ou contém menos de 0,2% em produtos legais), que é o composto psicoativo da cannabis. O CBD não produz efeitos intoxicantes. O seu cão não ficará "chapado" ou com comportamento alterado.
							</p>
						</div>
					</li>
					
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(244, 67, 54, 0.12); color: var(--mui-error); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">✗</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Mito: "Qualquer produto de CBD serve para cães"</h3>
									<p class="mui-typography-body1" style="margin: 0;">
								<strong>Verdade:</strong> Nem todos os produtos de CBD são seguros para cães. Evite produtos com sabores artificiais, adoçantes (especialmente xilitol, que é tóxico para cães) ou concentrações muito altas. Escolha produtos específicos para animais ou óleos de CBD puros sem aditivos.
							</p>
						</div>
					</li>
					
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(244, 67, 54, 0.12); color: var(--mui-error); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">✗</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Mito: "Mais CBD é sempre melhor"</h3>
									<p class="mui-typography-body1" style="margin: 0;">
										<strong>Verdade:</strong> A dosagem correta é crucial. Doses excessivas podem causar sonolência, boca seca ou diarreia. Sempre comece com a dose mais baixa e aumente gradualmente conforme necessário. Consulte a nossa <a href="#dosagem" class="mui-button mui-button-text" style="color: var(--mui-teal-primary);">tabela de dosagem</a> para orientações específicas.
							</p>
						</div>
					</li>
					
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(244, 67, 54, 0.12); color: var(--mui-error); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">✗</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Mito: "CBD funciona imediatamente"</h3>
									<p class="mui-typography-body1" style="margin: 0;">
								<strong>Verdade:</strong> Embora alguns efeitos possam ser notados em 30-60 minutos, muitos benefícios do CBD (especialmente para condições crónicas como artrite) podem levar dias ou semanas para se tornarem aparentes. Seja paciente e consistente na administração.
							</p>
						</div>
					</li>
					
							<li class="mui-list-item" style="display: flex; gap: 16px; align-items: flex-start;">
								<span style="flex-shrink: 0; width: 40px; height: 40px; background-color: rgba(244, 67, 54, 0.12); color: var(--mui-error); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 1.25rem;">✗</span>
								<div style="flex: 1;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">Mito: "CBD pode substituir todos os medicamentos veterinários"</h3>
									<p class="mui-typography-body1" style="margin: 0;">
								<strong>Verdade:</strong> O CBD é um tratamento complementar, não um substituto para medicamentos prescritos por veterinários. Sempre consulte um veterinário antes de fazer alterações na medicação do seu cão. O CBD pode interagir com certos medicamentos, especialmente aqueles metabolizados pelo fígado.
							</p>
						</div>
					</li>
				</ol>
					</div>
			</div>
		</div>
	</div>
</section>

	<!-- Signs of Overdose Section - MUI Alert -->
	<section class="overdose-signs-section py-16 md:py-20" style="background: var(--mui-gray-50);">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
			<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
					Sinais de que a Dosagem de CBD do Seu Cão é Demasiada
				</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
					Reconheça os sinais de dosagem excessiva e saiba como agir
				</p>
			</header>
			
				<div class="mui-alert mui-alert-warning mui-alert-elevated">
					<div class="mui-alert-icon">⚠</div>
					<div class="mui-alert-message">
						<p class="mui-typography-body1 mb-6" style="margin: 0 0 24px 0;">
					Embora o CBD seja geralmente seguro, doses excessivas podem causar efeitos colaterais. Se notar algum dos seguintes sinais, reduza a dose ou suspenda temporariamente e consulte um veterinário:
				</p>
						<ul class="mui-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
							<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
								<svg style="width: 24px; height: 24px; color: var(--mui-warning); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
						</svg>
								<span class="mui-typography-body1"><strong>Sonolência Excessiva:</strong> O seu cão está muito mais sonolento do que o normal ou tem dificuldade em acordar</span>
					</li>
							<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
								<svg style="width: 24px; height: 24px; color: var(--mui-warning); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
						</svg>
								<span class="mui-typography-body1"><strong>Boca Seca:</strong> O seu cão bebe água excessivamente ou parece ter a boca muito seca</span>
					</li>
							<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
								<svg style="width: 24px; height: 24px; color: var(--mui-warning); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
						</svg>
								<span class="mui-typography-body1"><strong>Diarreia ou Vómitos:</strong> Problemas digestivos que não existiam antes de iniciar o CBD</span>
					</li>
							<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
								<svg style="width: 24px; height: 24px; color: var(--mui-warning); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
						</svg>
								<span class="mui-typography-body1"><strong>Letargia:</strong> Falta de energia ou interesse em atividades normais</span>
					</li>
							<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
								<svg style="width: 24px; height: 24px; color: var(--mui-warning); flex-shrink: 0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
						</svg>
								<span class="mui-typography-body1"><strong>Mudanças no Apetite:</strong> Perda significativa de apetite ou aumento excessivo</span>
					</li>
				</ul>
						<div class="mui-card" style="margin-top: 24px; background: white; border: 1px solid var(--mui-gray-200);">
							<div class="mui-card-content">
								<p class="mui-typography-body2" style="margin: 0;">
						<strong>O que fazer:</strong> Se notar estes sinais, reduza a dose para metade ou suspenda temporariamente. A maioria dos efeitos colaterais desaparece em 24-48 horas. Se os sintomas persistirem ou piorarem, consulte imediatamente um veterinário.
					</p>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</section>

	<!-- Strategic Internal Links Section - MUI Cards Grid -->
	<section class="internal-links-section py-16 md:py-20">
	<div class="container mx-auto px-4">
		<div class="max-w-6xl mx-auto">
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<!-- Link to Homepage -->
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mui-card mui-card-elevated" style="text-decoration: none; display: block; transition: all 0.3s ease;">
						<div class="mui-card-content" style="text-align: center;">
							<svg style="width: 48px; height: 48px; color: var(--mui-teal-primary); margin: 0 auto 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
					</svg>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">Voltar ao Portal CBD</h3>
							<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">Aceda à nossa homepage para mais informações sobre CBD em Portugal</p>
						</div>
				</a>
				
				<!-- Link to Gatos -->
					<?php if ( $gatos_page ) : ?>
					<a href="<?php echo esc_url( get_permalink( $gatos_page->ID ) ); ?>" class="mui-card mui-card-elevated" style="text-decoration: none; display: block; transition: all 0.3s ease;">
						<div class="mui-card-content" style="text-align: center;">
							<span style="font-size: 48px; display: block; margin-bottom: 16px;">🐱</span>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">CBD para Gatos</h3>
							<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">Descubra as diferenças e cuidados específicos para gatos</p>
						</div>
				</a>
				<?php endif; ?>
				
				<!-- Link to Legislation -->
					<?php if ( $legislacao_page ) : ?>
					<a href="<?php echo esc_url( get_permalink( $legislacao_page->ID ) ); ?>" class="mui-card mui-card-elevated" style="text-decoration: none; display: block; transition: all 0.3s ease;">
						<div class="mui-card-content" style="text-align: center;">
							<svg style="width: 48px; height: 48px; color: var(--mui-blue-primary); margin: 0 auto 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
					</svg>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">Monitor de Legislação</h3>
							<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">Verifique o status legal atual do CBD em Portugal</p>
	</div>
								</a>
							<?php endif; ?>
				</div>
		</div>
	</div>
</section>

<!-- Schema.org HowTo and FAQPage -->
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@graph": [
		{
			"@type": "HowTo",
			"@id": "<?php echo esc_url( get_permalink() ); ?>#howto",
			"name": "Como Administrar Óleo de CBD ao Seu Cão em 5 Passos",
			"description": "Instruções seguras e eficazes para dar a dose correta de CBD ao seu cão",
			"step": [
				{
					"@type": "HowToStep",
					"position": 1,
					"name": "Calcular a Dose",
					"text": "Use a nossa tabela de dosagem para calcular os miligramas de CBD com base no peso do seu cão e na gravidade da condição. Sempre comece com a dose mais baixa recomendada."
				},
				{
					"@type": "HowToStep",
					"position": 2,
					"name": "Medir a Quantidade",
					"text": "Utilize o conta-gotas que vem com o frasco de óleo de CBD para medir a quantidade exata necessária. Verifique a concentração do produto (mg de CBD por ml) e calcule quantas gotas equivalem à dose desejada. Nunca administre mais do que a dose máxima recomendada."
				},
				{
					"@type": "HowToStep",
					"position": 3,
					"name": "Administrar o Óleo",
					"text": "Levante suavemente o focinho do seu cão e administre o óleo diretamente na boca, debaixo da língua (sublingual) ou na parte interna da bochecha. Alternativamente, pode misturar o óleo com a comida favorita do seu cão."
				},
				{
					"@type": "HowToStep",
					"position": 4,
					"name": "Observar a Reação",
					"text": "Monitore o seu cão durante as primeiras horas após a administração. Observe sinais de melhoria (redução de ansiedade, alívio de dor) ou possíveis efeitos colaterais (sonolência excessiva, boca seca)."
				},
				{
					"@type": "HowToStep",
					"position": 5,
					"name": "Ajustar Conforme Necessário",
					"text": "Após 3-5 dias de uso consistente, avalie a eficácia. Se não houver melhoria significativa e não houver efeitos colaterais, pode aumentar gradualmente a dose em pequenos incrementos (10-20%). Se notar efeitos colaterais, reduza a dose ou consulte um veterinário."
				}
			],
			"tool": [
				{
					"@type": "HowToTool",
					"name": "Óleo de CBD de espectro largo"
				},
				{
					"@type": "HowToTool",
					"name": "Tabela de Dosagem"
				},
				{
					"@type": "HowToTool",
					"name": "Conta-gotas incluído"
				}
			]
		},
		{
			"@type": "FAQPage",
			"@id": "<?php echo esc_url( get_permalink() ); ?>#faqpage",
			"mainEntity": [
				{
					"@type": "Question",
					"name": "Qual é a dosagem correta de CBD para o meu cão?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "A dosagem de CBD para cães varia conforme o peso e a condição. Para cães de 2-5 kg com condição ligeira, recomenda-se 0,5-1 mg, 2x ao dia. Para cães de 20-30 kg com condição crónica, pode ser necessário 15-25 mg, 2-3x ao dia. Consulte a nossa tabela de dosagem completa para calcular a dose exata baseada no peso do seu cão."
					}
				},
				{
					"@type": "Question",
					"name": "O CBD é seguro para cães?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "Sim, o CBD é geralmente seguro para cães quando administrado corretamente e em doses apropriadas. O CBD não contém THC (ou contém menos de 0,2% em produtos legais), não produzindo efeitos intoxicantes. No entanto, é essencial usar produtos de qualidade, seguir a dosagem correta e sempre consultar um veterinário antes de iniciar qualquer tratamento."
					}
				},
				{
					"@type": "Question",
					"name": "Quanto tempo demora o CBD a fazer efeito em cães?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "O CBD pode começar a fazer efeito em 30-60 minutos após a administração sublingual. No entanto, para condições crónicas como artrite ou ansiedade severa, pode levar alguns dias ou semanas de uso consistente para notar melhorias significativas. É importante ser paciente e manter uma administração regular."
					}
				},
				{
					"@type": "Question",
					"name": "O CBD pode ajudar com ansiedade canina?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "Sim, o CBD pode ajudar a reduzir a ansiedade em cães. Estudos e relatos de donos indicam que o CBD pode ajudar com ansiedade de separação, fobias (fogos de artifício, tempestades) e ansiedade social. Para ansiedade relacionada com eventos específicos, administre o CBD 30-60 minutos antes do evento previsto. Use a dose mínima da tabela de dosagem para ansiedade ligeira."
					}
				},
				{
					"@type": "Question",
					"name": "Posso dar CBD ao meu cão se ele já toma outros medicamentos?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "O CBD pode interagir com certos medicamentos veterinários, especialmente aqueles metabolizados pelo fígado. É crucial informar o seu veterinário sobre o uso de CBD antes de iniciar ou alterar qualquer medicação. O veterinário pode ajustar as doses ou monitorizar possíveis interações. Nunca interrompa medicamentos prescritos sem consultar um veterinário."
					}
				},
				{
					"@type": "Question",
					"name": "Quais são os sinais de dosagem excessiva de CBD em cães?",
					"acceptedAnswer": {
						"@type": "Answer",
						"text": "Sinais de dosagem excessiva incluem sonolência excessiva, boca seca (beber água excessivamente), diarreia ou vómitos, letargia e mudanças no apetite. Se notar estes sinais, reduza a dose para metade ou suspenda temporariamente. A maioria dos efeitos colaterais desaparece em 24-48 horas. Se os sintomas persistirem, consulte imediatamente um veterinário."
					}
				}
			]
		}
	]
}
</script>

	<script>
	(function() {
		// Show dosagem tab content by default (before Vue loads)
		function showDefaultTab() {
			const dosagemContent = document.getElementById('dosagem-tab-content');
			const segurancaContent = document.getElementById('seguranca-tab-content');
			const condicoesContent = document.getElementById('condicoes-tab-content');
			
			if (dosagemContent) {
				dosagemContent.style.display = 'block';
			}
			// Hide other tabs
			if (segurancaContent) {
				segurancaContent.style.display = 'none';
			}
			if (condicoesContent) {
				condicoesContent.style.display = 'none';
			}
		}
		
		// Run immediately if DOM is ready
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', showDefaultTab);
		} else {
			showDefaultTab();
		}
		
		function initCaesTabs() {
			if (typeof Vue === 'undefined') {
				setTimeout(initCaesTabs, 100);
				return;
			}
			
			const container = document.getElementById('caes-tabs-app');
			if (!container) return;
			
			// Check if already mounted
			if (container.__vue_app__) {
				return;
			}
			
			const { createApp } = Vue;
			
			try {
				const app = createApp({
					data() {
						return {
							activeTab: 'dosagem',
							tabs: [
								{ id: 'dosagem', label: 'Dosagem' },
								{ id: 'seguranca', label: 'Segurança' },
								{ id: 'condicoes', label: 'Condições' }
							]
						};
					},
					methods: {
						switchTab(tabId) {
							this.activeTab = tabId;
							// Hide all tab contents
							document.querySelectorAll('[id$="-tab-content"]').forEach(el => {
								el.style.display = 'none';
							});
							// Show active tab content
							const activeContent = document.getElementById(tabId + '-tab-content');
							if (activeContent) {
								activeContent.style.display = 'block';
							}
						}
					},
					mounted() {
						// Ensure initial tab is shown
						this.switchTab('dosagem');
					},
					template: `
						<div>
							<div class="mui-tabs">
								<button
									v-for="tab in tabs"
									:key="tab.id"
									:class="['mui-tab', { 'mui-tab-active': activeTab === tab.id }]"
									@click="switchTab(tab.id)"
								>
									{{ tab.label }}
								</button>
							</div>
						</div>
					`
				});
				app.mount('#caes-tabs-app');
			} catch (error) {
				if (typeof window.CBDDebug !== 'undefined') {
					window.CBDDebug.error('Erro ao inicializar tabs:', error);
				}
				// Fallback: show default tab content
				const defaultContent = document.getElementById('dosagem-tab-content');
				if (defaultContent) {
					defaultContent.style.display = 'block';
				}
			}
		}
		
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				setTimeout(initCaesTabs, 300);
			});
		} else {
			setTimeout(initCaesTabs, 300);
		}
	})();
	</script>
</main>

<?php
get_footer();
?>
