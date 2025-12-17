<?php
/**
 * Template Name: CBD para Gatos
 * 
 * Página especializada em CBD para gatos
 * Design MUI focado em segurança, sensibilidade e produtos Zero THC
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get related pages for internal links
$caes_page = get_page_by_path( 'cbd-para-caes' );
if ( ! $caes_page ) {
	$caes_page = get_page_by_path( 'caes' );
}
if ( ! $caes_page ) {
	$caes_page = get_page_by_path( 'cbd-caes' );
}

$legislacao_page = get_page_by_path( 'monitor-legislacao' );
if ( ! $legislacao_page ) {
	$legislacao_page = get_page_by_path( 'legislacao' );
}
?>

<!-- Hero Section - MUI Design Alerta de Segurança -->
<main class="main-content">
	<section class="hero-gatos py-12 md:py-20" style="background: linear-gradient(to bottom, var(--mui-gray-50), rgba(33, 150, 243, 0.05), var(--mui-gray-50));">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto text-center">
				<!-- Trust Badge - MUI Chip -->
				<div class="mui-chip mui-chip-primary mb-6" style="display: inline-flex;">
					<svg style="width: 16px; height: 16px; margin-right: 8px;" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
					</svg>
					<span>Especialistas em CBD para Gatos em Portugal</span>
				</div>
				
				<h1 class="mui-typography-h1 mb-6">
					<?php echo esc_html( cbd_ai_get_gatos_h1() ); ?>
				</h1>
				
				<p class="mui-typography-body1 mb-8" style="max-width: 640px; margin-left: auto; margin-right: auto; color: var(--mui-gray-700);">
					O guia veterinário definitivo sobre CBD para gatos. Aprenda sobre dosagem segura, produtos Zero THC e como evitar riscos para o seu felino.
				</p>
				
				<!-- Condition Keywords (SEO) - MUI Chips -->
				<div class="mui-chips-container" style="justify-content: center;">
					<span class="mui-chip">CBD gatos seguro</span>
					<span class="mui-chip">CBD zero THC gatos</span>
					<span class="mui-chip">dosagem CBD gatos</span>
					<span class="mui-chip">CBD ansiedade gatos</span>
				</div>
			</div>
		</div>
	</section>

	<!-- Critical Alert: THC Danger Section - MUI Alert Error -->
	<section class="thc-danger-section py-12">
		<div class="container mx-auto px-4">
			<div class="max-w-4xl mx-auto">
				<div class="mui-alert mui-alert-error mui-alert-elevated">
					<div class="mui-alert-icon" style="font-size: 2rem;">⚠</div>
					<div class="mui-alert-message">
						<h2 class="mui-typography-h3 mb-4" style="margin: 0 0 16px 0; font-weight: 600;">
							O Perigo do THC para Gatos: O que o Dono Precisa de Saber
						</h2>
						<div class="mui-typography-body1" style="line-height: 1.75;">
							<p class="mb-4">
								<strong>O THC (tetrahidrocanabinol) pode ser extremamente tóxico para gatos</strong> devido à forma única como os felinos metabolizam substâncias no fígado. Os gatos têm uma deficiência na enzima CYP450, que é crucial para metabolizar o THC de forma segura.
							</p>
							<p class="mb-4">
								<strong>Por que o CBD deve ser Zero THC para gatos?</strong> O metabolismo hepático dos gatos é diferente dos cães e humanos. Eles processam o CBD e outras substâncias mais lentamente, tornando-os mais sensíveis a efeitos colaterais. Qualquer quantidade de THC pode causar toxicidade, incluindo sintomas como:
							</p>
							<ul class="mui-list" style="list-style: none; padding: 0; margin: 0 0 16px 0;">
								<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
									<span style="color: var(--mui-error);">•</span>
									<span>Letargia extrema ou agitação</span>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
									<span style="color: var(--mui-error);">•</span>
									<span>Descoordenação motora</span>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
									<span style="color: var(--mui-error);">•</span>
									<span>Vómitos ou diarreia</span>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
									<span style="color: var(--mui-error);">•</span>
									<span>Alterações na frequência cardíaca</span>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px;">
									<span style="color: var(--mui-error);">•</span>
									<span>Convulsões (em casos severos)</span>
								</li>
							</ul>
							<div class="mui-alert mui-alert-error" style="margin-top: 24px; background: rgba(244, 67, 54, 0.1);">
								<div class="mui-alert-icon">⚠</div>
								<div class="mui-alert-message">
									<p class="mui-typography-body2" style="margin: 0; font-weight: 600;">
										<strong>Regra de Ouro:</strong> Use apenas produtos de CBD com <strong>0% THC</strong> (espectro isolado ou amplo testado). Nunca dê produtos de cannabis com THC ao seu gato, mesmo em quantidades mínimas.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Dosage Table Section - MUI Table -->
	<section class="dosage-table-section py-16 md:py-20">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						Tabela de Dosagem de CBD para Gatos por Peso e Condição
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						<strong>Importante:</strong> Devido à sensibilidade dos felinos, sempre comece com a dose mais baixa possível e aumente gradualmente apenas se necessário.
					</p>
				</header>
				
				<!-- Dosage Table - MUI Table -->
				<div class="mui-card mui-card-elevated mb-8">
					<div class="mui-table-container">
						<table class="mui-table">
							<thead>
								<tr>
									<th class="mui-table-head">Peso do Gato (kg)</th>
									<th class="mui-table-head" style="text-align: center;">Condição Ligeira<br><span class="mui-typography-caption" style="color: var(--mui-gray-600);">(Dose Baixa)</span></th>
									<th class="mui-table-head" style="text-align: center;">Condição Moderada<br><span class="mui-typography-caption" style="color: var(--mui-gray-600);">(Dose Média)</span></th>
									<th class="mui-table-head" style="text-align: center;">Condição Crónica<br><span class="mui-typography-caption" style="color: var(--mui-gray-600);">(Dose Máxima)</span></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">2-3 kg</td>
									<td class="mui-table-cell" style="text-align: center;">0,5-1 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">1-2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">1-2 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">2-3 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
								</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">3-4 kg</td>
									<td class="mui-table-cell" style="text-align: center;">1-1,5 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">1-2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">1,5-2,5 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">2,5-4 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
								</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">4-5 kg</td>
									<td class="mui-table-cell" style="text-align: center;">1,5-2 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">1-2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">2-3 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">3-5 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
								</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">5-6 kg</td>
									<td class="mui-table-cell" style="text-align: center;">2-2,5 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">1-2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">2,5-4 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">4-6 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
								</tr>
								<tr>
									<td class="mui-table-cell" style="font-weight: 500;">6+ kg</td>
									<td class="mui-table-cell" style="text-align: center;">2,5-3 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">1-2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">3-5 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
									<td class="mui-table-cell" style="text-align: center;">5-7 mg<br><span class="mui-typography-caption" style="color: var(--mui-gray-500);">2x ao dia</span></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				<!-- Table Disclaimer - MUI Alert -->
				<div class="mui-alert mui-alert-warning">
					<div class="mui-alert-icon">⚠</div>
					<div class="mui-alert-message">
						<h3 class="mui-typography-h6 mb-3" style="margin: 0 0 12px 0; font-weight: 600;">Importante sobre a Dosagem para Gatos</h3>
						<div class="mui-typography-body2" style="margin: 0;">
							<p style="margin: 0 0 8px 0;"><strong>Condição Ligeira:</strong> Ansiedade leve, stress ocasional, desconforto menor.</p>
							<p style="margin: 0 0 8px 0;"><strong>Condição Moderada:</strong> Ansiedade moderada, dor crônica leve, inflamação persistente.</p>
							<p style="margin: 0 0 8px 0;"><strong>Condição Crónica:</strong> Ansiedade severa, dor crônica intensa, condições inflamatórias.</p>
							<p style="margin: 0 0 8px 0;"><strong>⚠️ Regra Crítica:</strong> Gatos são muito mais sensíveis que cães. <strong>Sempre comece com a dose mais baixa</strong> e aumente apenas se necessário, sempre sob supervisão veterinária. Nunca exceda a dose máxima recomendada.</p>
							<p style="margin: 0; margin-top: 12px;"><strong>Mecanismo de Ação:</strong> O CBD interage com o sistema endocanabinoide dos gatos, mas devido ao metabolismo hepático único e à falta da enzima CYP450, a absorção e processamento são mais lentos, exigindo doses menores e produtos sem THC.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Product Formats Section - MUI Cards -->
	<section class="product-formats-section py-16 md:py-20" style="background: var(--mui-gray-50);">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						Formatos Ideais de CBD para Gatos vs. Formatos a Evitar
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Escolha o formato certo para garantir a segurança e eficácia do tratamento
					</p>
				</header>
				
				<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
					<!-- Ideal Formats -->
					<div class="mui-card mui-card-elevated" style="border: 2px solid rgba(76, 175, 80, 0.3);">
						<div class="mui-card-content">
							<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
								<div style="width: 48px; height: 48px; background-color: rgba(76, 175, 80, 0.12); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
									<svg style="width: 24px; height: 24px; color: var(--mui-success);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
									</svg>
								</div>
								<h3 class="mui-typography-h5" style="margin: 0; font-weight: 600;">Formatos Ideais ✅</h3>
							</div>
							<ul class="mui-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
								<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
									<svg style="width: 20px; height: 20px; color: var(--mui-success); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
									</svg>
									<div>
										<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 4px;">Óleo de CBD no Alimento:</strong>
										<p class="mui-typography-body2" style="margin: 0;">Misture o óleo com a comida favorita do seu gato. É a forma mais fácil e menos stressante de administrar.</p>
									</div>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
									<svg style="width: 20px; height: 20px; color: var(--mui-success); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
									</svg>
									<div>
										<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 4px;">Óleo Sublingual (sem sabor):</strong>
										<p class="mui-typography-body2" style="margin: 0;">Se o seu gato tolerar, administre diretamente na boca. Absorção mais rápida e eficaz.</p>
									</div>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
									<svg style="width: 20px; height: 20px; color: var(--mui-success); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
									</svg>
									<div>
										<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 4px;">Guloseimas Específicas para Gatos:</strong>
										<p class="mui-typography-body2" style="margin: 0;">Petiscos especialmente formulados para gatos, com doses baixas e sem ingredientes tóxicos.</p>
									</div>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
									<svg style="width: 20px; height: 20px; color: var(--mui-success); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
									</svg>
									<div>
										<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 4px;">Pasta Oral:</strong>
										<p class="mui-typography-body2" style="margin: 0;">Formato cremoso que pode ser aplicado nas patas ou misturado com comida.</p>
									</div>
								</li>
							</ul>
						</div>
					</div>
					
					<!-- Formats to Avoid -->
					<div class="mui-card mui-card-elevated" style="border: 2px solid rgba(244, 67, 54, 0.3);">
						<div class="mui-card-content">
							<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
								<div style="width: 48px; height: 48px; background-color: rgba(244, 67, 54, 0.12); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
									<svg style="width: 24px; height: 24px; color: var(--mui-error);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
									</svg>
								</div>
								<h3 class="mui-typography-h5" style="margin: 0; font-weight: 600;">Formatos a Evitar ❌</h3>
							</div>
							<ul class="mui-list" style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 16px;">
								<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
									<svg style="width: 20px; height: 20px; color: var(--mui-error); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
									</svg>
									<div>
										<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 4px;">Produtos com THC:</strong>
										<p class="mui-typography-body2" style="margin: 0;">Qualquer produto que contenha THC, mesmo em quantidades mínimas (0,2% ou menos), pode ser perigoso para gatos.</p>
									</div>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
									<svg style="width: 20px; height: 20px; color: var(--mui-error); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
									</svg>
									<div>
										<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 4px;">Produtos com Xilitol:</strong>
										<p class="mui-typography-body2" style="margin: 0;">Este adoçante é extremamente tóxico para gatos e pode causar insuficiência hepática.</p>
									</div>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
									<svg style="width: 20px; height: 20px; color: var(--mui-error); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
									</svg>
									<div>
										<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 4px;">Produtos para Humanos:</strong>
										<p class="mui-typography-body2" style="margin: 0;">Evite produtos de CBD formulados para humanos, que podem ter concentrações muito altas ou ingredientes não seguros para gatos.</p>
									</div>
								</li>
								<li class="mui-list-item" style="display: flex; gap: 12px; align-items: flex-start;">
									<svg style="width: 20px; height: 20px; color: var(--mui-error); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
									</svg>
									<div>
										<strong class="mui-typography-subtitle1" style="display: block; margin-bottom: 4px;">Produtos com Sabores Artificiais Fortes:</strong>
										<p class="mui-typography-body2" style="margin: 0;">Gatos são muito sensíveis a sabores e podem recusar produtos com sabores artificiais intensos.</p>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Condition-Specific Sections - MUI Cards -->
	<section class="conditions-specific-section py-16 md:py-20">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<header class="text-center mb-12">
					<h2 class="mui-typography-h2 mb-4">
						CBD para Condições Específicas em Gatos
					</h2>
					<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
						Guias detalhados sobre como usar CBD de forma segura para condições comuns em gatos
					</p>
				</header>
				
				<div style="display: flex; flex-direction: column; gap: 24px;">
					<!-- Condition 1: Anxiety -->
					<article class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h4 mb-4" style="font-weight: 600;">
								CBD para Ansiedade em Gatos
							</h3>
							<div class="mui-typography-body1" style="line-height: 1.75;">
								<p class="mb-4">
									A ansiedade em gatos pode manifestar-se através de comportamentos como esconder-se excessivamente, agressividade, marcação de território ou alterações nos hábitos de higiene. O CBD pode ajudar a promover calma e reduzir o stress.
								</p>
								<h4 class="mui-typography-h6 mb-3" style="font-weight: 600; margin-top: 24px;">Dosagem para Ansiedade em Gatos:</h4>
								<ul class="mui-list" style="list-style: none; padding: 0; margin: 0 0 16px 0;">
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Ansiedade Ligeira:</strong> Use a dose mínima da tabela (0,5-1 mg para gatos pequenos)</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Ansiedade Moderada:</strong> Use a dose média, mas sempre comece com a mínima</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Ansiedade Severa:</strong> Consulte um veterinário antes de usar doses mais altas</span>
									</li>
								</ul>
								<div class="mui-alert mui-alert-info" style="margin-top: 16px;">
									<div class="mui-alert-icon">💡</div>
									<div class="mui-alert-message">
										<p class="mui-typography-body2" style="margin: 0;"><strong>Dica:</strong> Para ansiedade relacionada com mudanças (mudança de casa, novos animais), administre o CBD 30-60 minutos antes do evento previsto. Use sempre produtos Zero THC.</p>
									</div>
								</div>
							</div>
						</div>
					</article>
					
					<!-- Condition 2: Pain -->
					<article class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h4 mb-4" style="font-weight: 600;">
								CBD para Dor e Inflamação em Gatos
							</h3>
							<div class="mui-typography-body1" style="line-height: 1.75;">
								<p class="mb-4">
									Gatos idosos ou com condições como artrite, dor pós-cirúrgica ou inflamação podem beneficiar do CBD. As propriedades anti-inflamatórias e analgésicas do CBD podem ajudar a melhorar a mobilidade e o conforto.
								</p>
								<h4 class="mui-typography-h6 mb-3" style="font-weight: 600; margin-top: 24px;">Dosagem para Dor em Gatos:</h4>
								<ul class="mui-list" style="list-style: none; padding: 0; margin: 0 0 16px 0;">
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Dor Ligeira:</strong> Comece com a dose mínima e aumente gradualmente se necessário</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Dor Crónica Moderada:</strong> Use a dose média da tabela, mas monitore cuidadosamente</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Dor Severa:</strong> Pode necessitar de doses mais altas, sempre sob supervisão veterinária</span>
									</li>
								</ul>
								<div class="mui-alert mui-alert-info" style="margin-top: 16px;">
									<div class="mui-alert-icon">ℹ</div>
									<div class="mui-alert-message">
										<p class="mui-typography-body2" style="margin: 0;"><strong>Nota:</strong> O efeito pode levar alguns dias a semanas para ser notado. Seja consistente na administração e mantenha um registo da melhoria do comportamento e mobilidade do seu gato.</p>
									</div>
								</div>
							</div>
						</div>
					</article>
					
					<!-- Condition 3: Digestive Issues -->
					<article class="mui-card mui-card-elevated">
						<div class="mui-card-content">
							<h3 class="mui-typography-h4 mb-4" style="font-weight: 600;">
								CBD para Problemas Digestivos em Gatos
							</h3>
							<div class="mui-typography-body1" style="line-height: 1.75;">
								<p class="mb-4">
									O CBD pode ajudar a regular o apetite, reduzir náuseas e melhorar problemas digestivos em gatos. É especialmente útil para gatos com síndrome do intestino irritável ou problemas de apetite.
								</p>
								<h4 class="mui-typography-h6 mb-3" style="font-weight: 600; margin-top: 24px;">Dosagem para Problemas Digestivos:</h4>
								<ul class="mui-list" style="list-style: none; padding: 0; margin: 0 0 16px 0;">
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Problemas Ligeiros:</strong> Use a dose mínima, geralmente 1x ao dia</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px; margin-bottom: 8px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Problemas Moderados:</strong> Pode ser necessário 2x ao dia, mas sempre comece com 1x</span>
									</li>
									<li class="mui-list-item" style="display: flex; gap: 12px;">
										<span style="color: var(--mui-teal-primary);">•</span>
										<span><strong>Administração:</strong> Misture com a comida para facilitar a ingestão</span>
									</li>
								</ul>
								<div class="mui-alert mui-alert-info" style="margin-top: 16px;">
									<div class="mui-alert-icon">💡</div>
									<div class="mui-alert-message">
										<p class="mui-typography-body2" style="margin: 0;"><strong>Dica:</strong> Se o seu gato recusar o óleo misturado com comida, tente administrar diretamente na boca com um conta-gotas, mas sempre com cuidado para não causar stress adicional.</p>
									</div>
								</div>
							</div>
						</div>
					</article>
				</div>
			</div>
		</div>
	</section>

	<!-- Strategic Internal Links Section - MUI Cards Grid -->
	<section class="internal-links-section py-16 md:py-20" style="background: var(--mui-gray-50);">
		<div class="container mx-auto px-4">
			<div class="max-w-6xl mx-auto">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
					<!-- Link to Homepage -->
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mui-card mui-card-elevated" style="text-decoration: none; display: block; transition: all 0.3s ease;">
						<div class="mui-card-content" style="text-align: center;">
							<svg style="width: 48px; height: 48px; color: var(--mui-blue-primary); margin: 0 auto 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
							</svg>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">Voltar ao Portal CBD</h3>
							<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">Aceda à nossa homepage para mais informações sobre CBD em Portugal</p>
						</div>
					</a>
					
					<!-- Link to Cães -->
					<?php if ( $caes_page ) : ?>
					<a href="<?php echo esc_url( get_permalink( $caes_page->ID ) ); ?>" class="mui-card mui-card-elevated" style="text-decoration: none; display: block; transition: all 0.3s ease;">
						<div class="mui-card-content" style="text-align: center;">
							<span style="font-size: 48px; display: block; margin-bottom: 16px;">🐕</span>
							<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">CBD para Cães</h3>
							<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">Para utilizadores que têm ambos os animais, descubra as diferenças</p>
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

	<!-- Schema.org FAQPage (Focused on Safety and Myths) -->
	<script type="application/ld+json">
	{
		"@context": "https://schema.org",
		"@type": "FAQPage",
		"@id": "<?php echo esc_url( get_permalink() ); ?>#faqpage",
		"mainEntity": [
			{
				"@type": "Question",
				"name": "O CBD é tóxico para os gatos?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "O CBD puro (Canabidiol) não é considerado tóxico, mas o THC pode ser extremamente tóxico para gatos devido à forma como metabolizam as substâncias no fígado. Os gatos têm uma deficiência na enzima CYP450, que é crucial para metabolizar o THC de forma segura. É crucial usar produtos com 0% THC, como o óleo de espectro isolado ou amplo testado."
				}
			},
			{
				"@type": "Question",
				"name": "Qual é a dosagem máxima de CBD para um gato de 4kg?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Devido à sensibilidade dos felinos, a dose deve ser sempre a mais baixa possível. Para um gato de 4kg com ansiedade ligeira, comece com 1mg a 2mg por dia e observe a reação, consultando sempre um veterinário. Para condições crónicas, a dose máxima pode chegar a 3-5mg, 2x ao dia, mas sempre sob supervisão veterinária."
				}
			},
			{
				"@type": "Question",
				"name": "Por que os gatos são mais sensíveis ao CBD que os cães?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Os gatos têm um metabolismo hepático único e uma deficiência na enzima CYP450, que é responsável por metabolizar muitas substâncias, incluindo o CBD e especialmente o THC. Isso significa que processam o CBD mais lentamente e são muito mais sensíveis a efeitos colaterais. Por isso, requerem doses menores e produtos sem THC."
				}
			},
			{
				"@type": "Question",
				"name": "Qual é a melhor forma de dar CBD ao meu gato?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "A melhor forma de dar CBD ao seu gato é misturando o óleo com a comida favorita dele. Isso reduz o stress e facilita a administração. Alternativamente, pode administrar diretamente na boca (sublingual) se o seu gato tolerar. Use sempre produtos Zero THC e comece com a dose mais baixa possível."
				}
			},
			{
				"@type": "Question",
				"name": "O CBD pode ajudar com ansiedade em gatos?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Sim, o CBD pode ajudar a reduzir a ansiedade em gatos quando usado corretamente. Para ansiedade ligeira, use a dose mínima da tabela de dosagem (0,5-1 mg para gatos pequenos). Para ansiedade relacionada com eventos específicos, administre o CBD 30-60 minutos antes do evento. Sempre use produtos Zero THC e consulte um veterinário para ansiedade severa."
				}
			},
			{
				"@type": "Question",
				"name": "Quais são os sinais de que o meu gato teve demasiado CBD?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Sinais de dosagem excessiva em gatos incluem sonolência extrema, letargia, vómitos, diarreia, descoordenação ou alterações no apetite. Se notar estes sinais, suspenda imediatamente a administração de CBD e consulte um veterinário. A maioria dos efeitos desaparece em 24-48 horas, mas é importante garantir que não há complicações."
				}
			},
			{
				"@type": "Question",
				"name": "Posso usar produtos de CBD para humanos no meu gato?",
				"acceptedAnswer": {
					"@type": "Answer",
					"text": "Não é recomendado usar produtos de CBD para humanos em gatos. Estes produtos podem ter concentrações muito altas, ingredientes não seguros para gatos (como xilitol ou sabores artificiais), ou podem conter THC. Use sempre produtos específicos para animais ou óleos de CBD puros testados, com 0% THC e concentrações adequadas para gatos."
				}
			}
		]
	}
	</script>
</main>

<?php
get_footer();
?>
