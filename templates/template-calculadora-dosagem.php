<?php
/**
 * Template Name: Calculadora de Dosagem de CBD
 * 
 * Template para a calculadora interativa de dosagem de CBD
 * Design MUI focado em inovação e precisão profissional
 *
 * @package CBD_AI_Theme
 * @since 1.0.0
 */

get_header();

// Get URLs for internal linking
$caes_url = '';
$gatos_url = '';
$animais_url = '';

$caes_page = get_page_by_path( 'cbd-para-caes' );
if ( ! $caes_page ) {
	$caes_page = get_page_by_path( 'cbd-animais/cbd-para-caes' );
}
if ( $caes_page ) {
	$caes_url = get_permalink( $caes_page->ID );
}

$gatos_page = get_page_by_path( 'cbd-para-gatos' );
if ( ! $gatos_page ) {
	$gatos_page = get_page_by_path( 'cbd-animais/cbd-para-gatos' );
}
if ( $gatos_page ) {
	$gatos_url = get_permalink( $gatos_page->ID );
}

$animais_page = get_page_by_path( 'cbd-para-animais' );
if ( ! $animais_page ) {
	$animais_page = get_page_by_path( 'cbd-animais' );
}
if ( $animais_page ) {
	$animais_url = get_permalink( $animais_page->ID );
}
?>

<main class="main-content py-8 md:py-12" style="background: linear-gradient(to bottom, var(--mui-gray-50), #ffffff, var(--mui-gray-50));">
	<div class="container mx-auto px-4">
		<div class="max-w-4xl mx-auto">
		
			<!-- Header Section - MUI Typography -->
		<div class="text-center mb-8 md:mb-12">
				<h1 class="mui-typography-h1 mb-4">
				Calculadora de Dosagem de CBD - Guia Preciso por Peso e Condição
			</h1>
				<p class="mui-typography-body1" style="max-width: 640px; margin: 0 auto; color: var(--mui-gray-600);">
				Calcule a dosagem correta de CBD para pessoas, cães e gatos com base no peso, condição e concentração do produto. Ferramenta gratuita e precisa.
			</p>
		</div>

			<!-- Disclaimer Banner - MUI Alert -->
			<div class="mui-alert mui-alert-warning mb-8">
				<div class="mui-alert-icon">⚠</div>
				<div class="mui-alert-message">
					<h3 class="mui-typography-subtitle1 mb-2" style="margin: 0 0 8px 0; font-weight: 600;">Aviso de Segurança</h3>
					<p class="mui-typography-body2" style="margin: 0;">
						A dose calculada é uma sugestão inicial. Consulte sempre um profissional de saúde/veterinário antes de iniciar o tratamento com CBD.
					</p>
				</div>
			</div>

			<!-- Calculator Card - MUI Card Central -->
			<div class="mui-card mui-card-elevated mb-8">
				<div class="mui-card-content">
					<form id="cbd-dosage-calculator">
					
						<!-- User Type Selection - MUI Tabs -->
					<div class="mb-8">
							<label class="mui-typography-subtitle2 mb-4" style="display: block; color: var(--mui-gray-700);">
							Tipo de Utilizador
						</label>
							<div class="mui-tabs">
							<button 
								type="button"
								data-user-type="pessoa"
									class="mui-tab mui-tab-active"
									style="flex: 1;"
							>
									<span style="display: block; font-size: 1.5rem; margin-bottom: 4px;">👤</span>
									<span>Pessoa</span>
							</button>
							<button 
								type="button"
								data-user-type="cao"
									class="mui-tab"
									style="flex: 1;"
							>
									<span style="display: block; font-size: 1.5rem; margin-bottom: 4px;">🐕</span>
									<span>Cão</span>
							</button>
							<button 
								type="button"
								data-user-type="gato"
									class="mui-tab"
									style="flex: 1;"
							>
									<span style="display: block; font-size: 1.5rem; margin-bottom: 4px;">🐱</span>
									<span>Gato</span>
							</button>
						</div>
						<input type="hidden" id="user-type" name="user_type" value="pessoa" required>
					</div>

						<!-- Weight Input - MUI Text Field -->
						<div class="mui-text-field mb-6">
							<label for="weight" class="mui-text-field-label mui-text-field-label-shrink">
								Peso (kg)
							</label>
							<input 
								type="number" 
								id="weight" 
								name="weight" 
								min="0.1" 
								step="0.1" 
								required
								class="mui-input mui-input-outlined"
								placeholder=""
							>
							<div class="mui-input-helper-text">Digite o peso em quilogramas (ex: 70)</div>
						</div>

						<!-- Product Concentration Input - MUI Text Field -->
						<div class="mui-text-field mb-6">
							<label for="concentration" class="mui-text-field-label mui-text-field-label-shrink">
								Concentração do Produto (mg CBD por ml)
							</label>
							<input 
								type="number" 
								id="concentration" 
								name="concentration" 
								min="0.1" 
								step="0.1" 
								required
								class="mui-input mui-input-outlined"
								placeholder=""
							>
							<div class="mui-input-helper-text">Calcule: mg total de CBD na garrafa ÷ ml da garrafa (ex: 10)</div>
						</div>

						<!-- Condition Severity Dropdown - MUI Select -->
						<div class="mui-text-field mb-6">
							<label for="severity" class="mui-text-field-label mui-text-field-label-shrink">
								Gravidade da Condição
							</label>
							<select 
								id="severity" 
								name="severity" 
								required
								class="mui-input mui-input-outlined"
							>
								<option value="">Selecione a gravidade...</option>
								<option value="leve">Leve (Stress diário, sono ligeiro)</option>
								<option value="media">Média (Ansiedade, dores crónicas moderadas)</option>
								<option value="elevada">Elevada (Dores severas, epilepsia)</option>
							</select>
						</div>

						<!-- Calculate Button - MUI Button -->
					<button 
						type="submit"
							class="mui-button mui-button-contained mui-button-primary"
							style="width: 100%; padding: 16px; font-size: 1.125rem; font-weight: 600;"
					>
						Calcular Dosagem
					</button>

				</form>
				</div>
			</div>

			<!-- Results Section (Hidden by default) - MUI Cards -->
			<div id="results-section" class="hidden">
				<div class="mui-card mui-card-elevated mb-8" style="border-top: 2px solid var(--mui-gray-200); background: linear-gradient(to bottom right, rgba(33, 150, 243, 0.05), rgba(76, 175, 80, 0.05));">
					<div class="mui-card-content">
						<h2 class="mui-typography-h3 mb-6 text-center" style="font-weight: 600;">
						Resultado do Cálculo
					</h2>
					
					<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
						<!-- Dose in mg -->
							<div class="mui-card" style="background: white; border: 2px solid rgba(33, 150, 243, 0.3);">
								<div class="mui-card-content">
									<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
										<div style="width: 48px; height: 48px; background-color: rgba(33, 150, 243, 0.12); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
											<svg style="width: 24px; height: 24px; color: var(--mui-blue-primary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
									</svg>
										</div>
										<h3 class="mui-typography-h6" style="margin: 0; font-weight: 600;">Dose Sugerida</h3>
									</div>
									<p class="mui-typography-h3 mb-1" style="margin: 0; color: var(--mui-blue-primary); font-weight: 600;" id="dose-mg">-</p>
									<p class="mui-typography-caption" style="margin: 0; color: var(--mui-gray-600);">miligramas de CBD</p>
								</div>
						</div>

						<!-- Dose in drops -->
							<div class="mui-card" style="background: white; border: 2px solid rgba(76, 175, 80, 0.3);">
								<div class="mui-card-content">
									<div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
										<div style="width: 48px; height: 48px; background-color: rgba(76, 175, 80, 0.12); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
											<svg style="width: 24px; height: 24px; color: var(--mui-success);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
									</svg>
										</div>
										<h3 class="mui-typography-h6" style="margin: 0; font-weight: 600;">Dose em Gotas</h3>
									</div>
									<p class="mui-typography-h3 mb-1" style="margin: 0; color: var(--mui-success); font-weight: 600;" id="dose-drops">-</p>
									<p class="mui-typography-caption" style="margin: 0; color: var(--mui-gray-600);">gotas (aproximadamente)</p>
								</div>
						</div>
					</div>

						<!-- Adjustment Warning - MUI Alert -->
						<div class="mui-alert mui-alert-warning">
							<div class="mui-alert-icon">⚠</div>
							<div class="mui-alert-message">
								<p class="mui-typography-subtitle1 mb-2" style="margin: 0 0 8px 0; font-weight: 600;">
									Recomendação de Ajuste
								</p>
								<p class="mui-typography-body2" style="margin: 0;">
									Comece sempre pela dose mais baixa e aumente gradualmente conforme necessário. Observe a resposta do organismo e ajuste a dosagem sob supervisão profissional. Cada pessoa/animal pode reagir de forma diferente ao CBD.
								</p>
						</div>
					</div>

						<!-- CTA de Conversão/Afiliação - MUI Card -->
						<div id="affiliate-cta" class="hidden mt-6">
							<div class="mui-card" style="background: linear-gradient(to right, rgba(76, 175, 80, 0.1), rgba(33, 150, 243, 0.1)); border: 2px solid rgba(76, 175, 80, 0.3);">
								<div class="mui-card-content" style="text-align: center;">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600;">
								Encontrou a dose? Compre Agora o Óleo CBD Recomendado
							</h3>
									<p class="mui-typography-body2 mb-4" style="margin: 0 0 16px 0; color: var(--mui-gray-700);">
								Produtos testados e validados com a concentração certa para a sua dosagem calculada.
							</p>
							<a 
								href="#produtos-recomendados" 
										class="mui-button mui-button-contained mui-button-primary"
										style="display: inline-flex; align-items: center; gap: 8px;"
							>
								Ver Produtos Recomendados
										<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
								</svg>
							</a>
								</div>
						</div>
					</div>

						<!-- Reset Button - MUI Button -->
					<button 
						type="button"
						id="reset-calculator"
							class="mui-button mui-button-outlined"
							style="width: 100%; margin-top: 24px;"
					>
						Calcular Novamente
					</button>
				</div>
			</div>
		</div>

			<!-- Content Support Section (SEO/GEO) - MUI Card -->
			<div class="mui-card mui-card-elevated mb-8">
				<div class="mui-card-content">
					<h2 class="mui-typography-h3 mb-6" style="font-weight: 600;">
				Metodologia e Fórmulas de Cálculo
			</h2>
			
					<div class="mui-typography-body1" style="line-height: 1.75;">
						<p class="mb-6">
					A nossa calculadora de dosagem de CBD utiliza fórmulas baseadas em protocolos de dosagem padrão validados por estudos científicos e práticas veterinárias. As dosagens são calculadas em <strong>miligramas de CBD por quilograma de peso corporal (mg/kg)</strong>, ajustadas conforme a gravidade da condição a tratar.
				</p>

						<h3 class="mui-typography-h5 mb-4" style="font-weight: 600; margin-top: 32px;">
					Fórmulas de Dosagem por Tipo de Utilizador
				</h3>
				
						<!-- Dosage Table - MUI Table -->
						<div class="mui-table-container mb-6">
							<table class="mui-table">
						<thead>
									<tr>
										<th class="mui-table-head">Tipo de Utilizador</th>
										<th class="mui-table-head" style="text-align: center;">Gravidade Leve<br><span class="mui-typography-caption" style="color: var(--mui-gray-600);">(mg/kg)</span></th>
										<th class="mui-table-head" style="text-align: center;">Gravidade Média<br><span class="mui-typography-caption" style="color: var(--mui-gray-600);">(mg/kg)</span></th>
										<th class="mui-table-head" style="text-align: center;">Gravidade Elevada<br><span class="mui-typography-caption" style="color: var(--mui-gray-600);">(mg/kg)</span></th>
							</tr>
						</thead>
						<tbody>
							<tr>
										<td class="mui-table-cell" style="font-weight: 500;">Pessoa</td>
										<td class="mui-table-cell" style="text-align: center;">0.25 mg/kg</td>
										<td class="mui-table-cell" style="text-align: center;">0.5 mg/kg</td>
										<td class="mui-table-cell" style="text-align: center;">1.0 mg/kg</td>
							</tr>
									<tr>
										<td class="mui-table-cell" style="font-weight: 500;">Cão</td>
										<td class="mui-table-cell" style="text-align: center;">0.2 mg/kg</td>
										<td class="mui-table-cell" style="text-align: center;">0.4 mg/kg</td>
										<td class="mui-table-cell" style="text-align: center;">0.8 mg/kg</td>
							</tr>
							<tr>
										<td class="mui-table-cell" style="font-weight: 500;">Gato</td>
										<td class="mui-table-cell" style="text-align: center;">0.1 mg/kg</td>
										<td class="mui-table-cell" style="text-align: center;">0.2 mg/kg</td>
										<td class="mui-table-cell" style="text-align: center;">0.4 mg/kg</td>
							</tr>
						</tbody>
					</table>
				</div>

						<p class="mb-6">
					<strong>Exemplo de cálculo:</strong> Para um cão de 20 kg com condição de gravidade média, a dose total seria: <strong>20 kg × 0.4 mg/kg = 8 mg de CBD</strong>. Se o produto tiver uma concentração de 10 mg de CBD por ml, isso corresponde a 0.8 ml ou aproximadamente <strong>16 gotas</strong> (assumindo que 1 ml = 20 gotas).
				</p>

						<h3 class="mui-typography-h5 mb-4" style="font-weight: 600; margin-top: 32px;">
					Porque é que a Dosagem de CBD para Gatos é Diferente?
				</h3>
				
						<p class="mb-6">
					Os gatos têm um metabolismo hepático único que os torna mais sensíveis ao CBD e especialmente vulneráveis ao THC. Diferentemente dos cães e humanos, os felinos não possuem a enzima CYP450 em quantidade suficiente para metabolizar eficientemente os canabinoides. Por esta razão, <strong>a dosagem inicial para gatos é sempre mais baixa</strong> (0.1 mg/kg para condições leves) e é absolutamente crítico usar apenas produtos com <strong>0% de THC</strong>. Produtos de espectro isolado ou amplo (com THC removido) são os únicos seguros para gatos.
				</p>

						<h3 class="mui-typography-h5 mb-4" style="font-weight: 600; margin-top: 32px;">
					Ajuste Gradual da Dose e Segurança
				</h3>
				
						<p class="mb-6">
					É fundamental começar sempre pela <strong>dose mais baixa recomendada</strong> e aumentar gradualmente ao longo de 1-2 semanas, observando cuidadosamente a resposta do organismo. Sinais de que a dosagem pode estar demasiada incluem: sonolência excessiva, boca seca, tonturas ou alterações no apetite. Se estes sintomas ocorrerem, reduza a dose imediatamente e consulte um profissional de saúde ou veterinário. O ajuste gradual permite que o sistema endocanabinoide se adapte e minimiza o risco de efeitos secundários.
				</p>

						<div class="mui-alert mui-alert-info" style="margin-top: 24px;">
							<div class="mui-alert-icon">💡</div>
							<div class="mui-alert-message">
								<p class="mui-typography-subtitle1 mb-2" style="margin: 0 0 8px 0; font-weight: 600;">
									Dica Profissional
					</p>
								<p class="mui-typography-body2" style="margin: 0;">
						Mantenha um diário de dosagem registando a dose administrada, a hora e os efeitos observados. Isto ajuda a identificar a dose ideal e facilita a comunicação com o seu médico ou veterinário.
					</p>
							</div>
						</div>
				</div>
			</div>
		</div>

			<!-- Internal Links Section (SEO) - MUI Cards Grid -->
			<div class="mui-card mui-card-elevated mb-8" style="background: linear-gradient(to right, var(--mui-gray-50), rgba(33, 150, 243, 0.05));">
				<div class="mui-card-content">
					<h2 class="mui-typography-h3 mb-6" style="font-weight: 600;">
				Guias Relacionados para Aprofundamento
			</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
						<?php if ( $caes_url ) : ?>
							<a href="<?php echo esc_url( $caes_url ); ?>" class="mui-card" style="background: white; border: 2px solid var(--mui-gray-200); text-decoration: none; display: block; transition: all 0.3s ease;">
								<div class="mui-card-content">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">
							📊 Tabela de Dosagem CBD para Cães
						</h3>
									<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">
							Guia detalhado com tabelas de dosagem por peso e condição específica para cães.
						</p>
								</div>
					</a>
				<?php endif; ?>

						<?php if ( $gatos_url ) : ?>
							<a href="<?php echo esc_url( $gatos_url ); ?>" class="mui-card" style="background: white; border: 2px solid var(--mui-gray-200); text-decoration: none; display: block; transition: all 0.3s ease;">
								<div class="mui-card-content">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">
							🐱 Guia de CBD para Gatos
						</h3>
									<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">
							Informação crítica sobre segurança, dosagem segura e produtos sem THC para gatos.
						</p>
								</div>
					</a>
				<?php endif; ?>

						<?php if ( $animais_url ) : ?>
							<a href="<?php echo esc_url( $animais_url ); ?>" class="mui-card" style="background: white; border: 2px solid var(--mui-gray-200); text-decoration: none; display: block; transition: all 0.3s ease;">
								<div class="mui-card-content">
									<h3 class="mui-typography-h6 mb-2" style="font-weight: 600; color: var(--mui-gray-900);">
							🐾 CBD para Animais - Guia Completo
						</h3>
									<p class="mui-typography-body2" style="margin: 0; color: var(--mui-gray-600);">
							Comparação entre CBD para cães e gatos, benefícios e segurança veterinária.
						</p>
								</div>
					</a>
				<?php endif; ?>
					</div>
			</div>
		</div>

			<!-- Additional Information Section - MUI Card -->
			<div class="mui-card mui-card-elevated">
				<div class="mui-card-content">
					<h2 class="mui-typography-h3 mb-6" style="font-weight: 600;">
				Informações Importantes
			</h2>
					<div style="display: flex; flex-direction: column; gap: 16px;">
						<div style="display: flex; gap: 12px; align-items: flex-start;">
							<svg style="width: 24px; height: 24px; color: var(--mui-success); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
					</svg>
							<p class="mui-typography-body1" style="margin: 0;">
						<strong>Conversão padrão:</strong> 1 ml de óleo corresponde a aproximadamente 20 gotas.
					</p>
				</div>
						<div style="display: flex; gap: 12px; align-items: flex-start;">
							<svg style="width: 24px; height: 24px; color: var(--mui-success); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
					</svg>
							<p class="mui-typography-body1" style="margin: 0;">
						<strong>Dosagem inicial:</strong> Sempre comece com a dose mais baixa recomendada e aumente gradualmente.
					</p>
				</div>
						<div style="display: flex; gap: 12px; align-items: flex-start;">
							<svg style="width: 24px; height: 24px; color: var(--mui-success); flex-shrink: 0; margin-top: 2px;" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
					</svg>
							<p class="mui-typography-body1" style="margin: 0;">
						<strong>Supervisão profissional:</strong> Consulte sempre um médico ou veterinário antes de iniciar qualquer tratamento com CBD.
					</p>
						</div>
				</div>
			</div>
		</div>

		</div>
	</div>
</main>

<?php
// Generate HowTo Schema for Calculator
$howto_schema = array(
	'@context' => 'https://schema.org',
	'@type' => 'HowTo',
	'name' => 'Como Usar a Calculadora de Dosagem de CBD',
	'description' => 'Siga estes passos simples para calcular a sua dose de CBD para pessoas, cães ou gatos com base no peso, condição e concentração do produto.',
	'step' => array(
		array(
			'@type' => 'HowToStep',
			'name' => 'Passo 1: Selecione o Utilizador',
			'text' => 'Escolha se o cálculo é para um ser humano, cão ou gato usando os botões de seleção.',
			'position' => 1,
		),
		array(
			'@type' => 'HowToStep',
			'name' => 'Passo 2: Insira o Peso',
			'text' => 'Introduza o peso atual em quilogramas (kg) no campo de peso.',
			'position' => 2,
		),
		array(
			'@type' => 'HowToStep',
			'name' => 'Passo 3: Selecione a Gravidade da Condição',
			'text' => 'Selecione o nível de gravidade da condição que pretende tratar: Leve (stress diário, sono ligeiro), Média (ansiedade, dores crónicas moderadas) ou Elevada (dores severas, epilepsia).',
			'position' => 3,
		),
		array(
			'@type' => 'HowToStep',
			'name' => 'Passo 4: Insira a Concentração do Produto',
			'text' => 'Consulte a embalagem do seu produto de CBD e insira os miligramas de CBD por mililitro (mg/ml). Calcule dividindo o total de mg de CBD na garrafa pelo volume em ml.',
			'position' => 4,
		),
		array(
			'@type' => 'HowToStep',
			'name' => 'Passo 5: Calcule e Ajuste',
			'text' => 'Clique em "Calcular Dosagem" e obtenha a dose sugerida em miligramas e gotas. Comece sempre pela dose mais baixa recomendada e ajuste gradualmente conforme necessário, sob supervisão profissional.',
			'position' => 5,
		),
	),
);

// Output Schema JSON-LD
echo '<script type="application/ld+json">' . "\n";
echo wp_json_encode( $howto_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
echo "\n" . '</script>' . "\n";
?>

<script>
(function() {
	'use strict';

	// Dosage factors (mg/kg) based on user type and severity
	const DOSAGE_FACTORS = {
		pessoa: {
			leve: 0.25,
			media: 0.5,
			elevada: 1.0
		},
		cao: {
			leve: 0.2,
			media: 0.4,
			elevada: 0.8
		},
		gato: {
			leve: 0.1,
			media: 0.2,
			elevada: 0.4
		}
	};

	// Constants
	const DROPS_PER_ML = 20;

	// DOM Elements
	const form = document.getElementById('cbd-dosage-calculator');
	const tabs = document.querySelectorAll('[data-user-type]');
	const userTypeInput = document.getElementById('user-type');
	const resultsSection = document.getElementById('results-section');
	const doseMgElement = document.getElementById('dose-mg');
	const doseDropsElement = document.getElementById('dose-drops');
	const resetButton = document.getElementById('reset-calculator');

	// Tab switching functionality
	tabs.forEach(tab => {
		tab.addEventListener('click', function() {
			// Remove active class from all tabs
			tabs.forEach(t => {
				t.classList.remove('mui-tab-active');
			});
			// Add active class to clicked tab
			this.classList.add('mui-tab-active');
			// Update hidden input
			userTypeInput.value = this.getAttribute('data-user-type');
		});
	});

	// Form Submission
	form.addEventListener('submit', function(e) {
		e.preventDefault();
		
		// Get form values
		const userType = userTypeInput.value;
		const weight = parseFloat(document.getElementById('weight').value);
		const concentration = parseFloat(document.getElementById('concentration').value);
		const severity = document.getElementById('severity').value;
		
		// Validation
		if (!userType || !weight || !concentration || !severity) {
			alert('Por favor, preencha todos os campos.');
			return;
		}
		
		if (weight <= 0 || concentration <= 0) {
			alert('Por favor, insira valores válidos maiores que zero.');
			return;
		}
		
		// Calculate dosage
		const dosageFactor = DOSAGE_FACTORS[userType][severity];
		const totalDoseMg = weight * dosageFactor;
		const doseMl = totalDoseMg / concentration;
		const doseDrops = doseMl * DROPS_PER_ML;
		
		// Round results
		const roundedDoseMg = Math.round(totalDoseMg * 10) / 10;
		const roundedDoseDrops = Math.round(doseDrops);
		
		// Display results
		doseMgElement.textContent = roundedDoseMg + ' mg';
		doseDropsElement.textContent = roundedDoseDrops + ' gotas';
		
		// Show results section
		resultsSection.classList.remove('hidden');
		
		// Show affiliate CTA
		const affiliateCTA = document.getElementById('affiliate-cta');
		if (affiliateCTA) {
			affiliateCTA.classList.remove('hidden');
		}
		
		// Scroll to results
		resultsSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
	});

	// Reset Calculator
	resetButton.addEventListener('click', function() {
		form.reset();
		resultsSection.classList.add('hidden');
		// Reset to first tab
		if (tabs.length > 0) {
			tabs[0].click();
		}
		
		// Hide affiliate CTA
		const affiliateCTA = document.getElementById('affiliate-cta');
		if (affiliateCTA) {
			affiliateCTA.classList.add('hidden');
		}
		
		// Scroll to top of form
		form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
	});

})();
</script>

<?php
get_footer();
?>
