@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title">
        <h1><i class="bi bi-pencil"></i> Editar Guia de SADT</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('guia.sp.atualizar') }}">
                @csrf
                @method('POST')

                {{-- SADT Form --}}
                <div>
                    <input type="hidden" name="convenio_id" value="{{ $guiaSadt->convenio_id }}">
                    <h5 class="modal-title">Guia SADT</h5>
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="registro_ans" class="form-label"><strong>1- Registro ANS</strong></label>
                            <input class="form-control" id="registro_ans" name="registro_ans" type="text"
                                value="{{ old('registro_ans', $guiaSadt->registro_ans) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="numero_guia_prestador" class="form-label">3- Nº Guia Principal</label>
                            <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador"
                                type="text" value="{{ old('numero_guia_prestador', $guiaSadt->numero_guia_prestador) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="data_autorizacao" class="form-label">4- Data da Autorização</label>
                            <input class="form-control" id="data_autorizacao" name="data_autorizacao"
                                type="date" value="{{ old('data_autorizacao', $guiaSadt->data_autorizacao) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="senha" class="form-label">5- Senha</label>
                            <input class="form-control" id="senha" name="senha" type="text"
                                value="{{ old('senha', $guiaSadt->senha) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="validade_senha" class="form-label">6- Data de Validade da Senha</label>
                            <input class="form-control" id="validade_senha" name="validade_senha" type="date"
                                value="{{ old('validade_senha', $guiaSadt->validade_senha) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="numero_guia_op" class="form-label">7- Nº da Guia Atribuído pela
                                Operadora</label>
                            <input class="form-control" id="numero_guia_op" name="numero_guia_op" type="text"
                                value="{{ old('numero_guia_op', $guiaSadt->numero_guia_op) }}">
                        </div>
                    </div>
                    <hr>
                    <h5>Dados do Beneficiário</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="numero_carteira" class="form-label">8 - Nº da Carteira</label>
                            <input class="form-control" id="numero_carteira" name="numero_carteira"
                                type="text" value="{{ old('numero_carteira', $guiaSadt->numero_carteira) }}">
                        </div>
                        <div class="col-md-2">
                            <label for="validade_carteira" class="form-label">9 - Validade da Carteira</label>
                            <input class="form-control" id="validade_carteira" name="validade_carteira"
                                type="date" value="{{ old('validade_carteira', $guiaSadt->validade_carteira) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nome_beneficiario" class="form-label">10 - Nome</label>
                            <input class="form-control" id="nome_beneficiario" name="nome_beneficiario"
                                type="text" value="{{ old('nome_beneficiario', $guiaSadt->nome_beneficiario) }}">
                        </div>
                        <div class="col-md-2">
                            <label for="nome_social" class="form-label">11 - CNS</label>
                            <input class="form-control" id="cns" name="cns" type="text"
                                value="{{ old('cns', $guiaSadt->cns) }}">
                        </div>
                        <div class="col-md-2">
                            <label for="atendimento_rn" class="form-label">12 - Atendimento RN</label>
                            <select class="form-select" id="atendimento_rn" name="atendimento_rn">
                                <option value="N" {{ old('atendimento_rn', $guiaSadt->atendimento_rn) == '1' ? 'selected' : '' }}>Não
                                </option>
                                <option value="S" {{ old('atendimento_rn', $guiaSadt->atendimento_rn) == '2' ? 'selected' : '' }}>Sim
                                </option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h5>Dados do Solicitante</h5>
                    <div class="row md-3">
                        <div class="col-md-3">
                            <label for="codigo_operadora" class="form-label">13 - Código Operadora</label>
                            <input class="form-control" id="codigo_operadora" name="codigo_operadora"
                                type="text" value="{{ old('codigo_operadora', $guiaSadt->codigo_operadora) }}">
                        </div>
                        <div class="col-md-9">
                            <label for="nome_contratado" class="form-label">14 - Nome Contratado</label>
                            <input class="form-control" id="nome_contratado" name="nome_contratado"
                                type="text" value="{{ old('nome_contratado', $guiaSadt->nome_contratado) }}">
                        </div>
                    </div>
                    <div class="row md-3">
                        <div class="col-md-5">
                            <label for="nome_profissional_solicitante" class="form-label">15- Nome do Profissional
                                Solicitante</label>
                            <input class="form-control" id="nome_profissional_solicitante"
                                name="nome_profissional_solicitante" type="text"
                                value="{{ old('nome_profissional_solicitante', $guiaSadt->nome_profissional_solicitante) }}">
                        </div>
                        <div class="col-md-2">
                            <label for="conselho_profissional" class="form-label">16- Conselho</label>
                            <select name="conselho_profissional" id="conselho_profissional" class="form-select">
                                <option value="" disabled selected>Selecione</option>
                                @foreach ($conselhos as $sigla => $codigo)
                                    <option value="{{ $codigo }}"
                                        {{ old('conselho_profissional', $guiaSadt->conselho_profissional) == $codigo ? 'selected' : '' }}>
                                        {{ $sigla }} <!-- Exibe a sigla -->
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="numero_conselho" class="form-label">17- Nº Conselho</label>
                            <input class="form-control" id="numero_conselho" name="numero_conselho"
                                type="text" value="{{ old('numero_conselho', $guiaSadt->numero_conselho) }}">
                        </div>
                        <div class="col-md-1">
                            <label for="uf_conselho" class="form-label">18- UF</label>
                            <select name="uf_conselho" id="uf_conselho" class="form-select">
                                <option selected disabled>Selecione</option>
                                @foreach ($ufs as $uf => $codigo)
                                    <option value="{{ $codigo }}"
                                        {{ old('uf_conselho', $guiaSadt->uf_conselho) == $codigo ? 'selected' : '' }}>
                                        {{ $uf }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="codigo_cbo" class="form-label">19- Código CBO</label>
                            <input class="form-control" id="codigo_cbo" name="codigo_cbo" type="text"
                                value="{{ old('codigo_cbo', $guiaSadt->codigo_cbo) }}">
                        </div>
                    </div>
                    <hr>
                    <h5>Dados da Solicitação / Procedimentos e Exames Solicitados</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="carater_atendimento" class="form-label">21 - Caráter de
                                Atendimento</label>
                            <select class="form-select" id="carater_atendimento" name="carater_atendimento">
                                <option value="">Selecione</option>
                                <option value="1" {{ old('carater_atendimento', $guiaSadt->carater_atendimento) == '1' ? 'selected' : '' }}>
                                    Eletivo
                                </option>
                                <option value="2" {{ old('carater_atendimento', $guiaSadt->carater_atendimento) == '2' ? 'selected' : '' }}>
                                    Urgência/Emergência
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="data_solicitacao" class="form-label">22 - Data/Hora Solicitação</label>
                            <input class="form-control" id="data_solicitacao" name="data_solicitacao"
                                type="date" value="{{ old('data_solicitacao', $guiaSadt->data_solicitacao) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="indicacao_clinica" class="form-label">23 - Indicação Clínica</label>
                            <select class="form-select" id="indicacao_clinica" name="indicacao_clinica">
                                <option value="">{{ old('indicacao_clinica', $guiaSadt->indicacao_clinica) ? old('indicacao_clinica', $guiaSadt->indicacao_clinica) : 'Selecione' }}</option>
                                <option value="DOR ABDOMINAL">Dor Abdominal</option>
                                <option value="DOR DE CABEÇA FREQUENTE">Dor de Cabeça Frequente</option>
                                <option value="FADIGA">Fadiga</option>
                                <option value="SINTOMAS RESPIRATORIOS">Sintomas Respiratórios</option>
                                <option value="HIPERTENSÃO">Hipertensão</option>
                                <option value="DIABETES">Diabetes</option>
                                <option value="SUSPEITA DE FRATURA">Suspeita de Fratura</option>
                                <option value="AVALIAÇÃO DE FUNÇÃO HEPÁTICA">Avaliação de Função Hepática</option>
                                <option value="ANEMIA">Anemia</option>
                                <option value="PERDA DE PESO INEXPLICADA">Perda de Peso Inexplicada</option>
                                <option value="INFECÇÕES RECORRENTES">Infecções Recorrentes</option>
                                <option value="SINTOMAS GASTROINTESTINAIS">Sintomas Gastrointestinais</option>
                                <option value="SINTOMAS CARDIOVASCULARES">Sintomas Cardiovasculares</option>
                                <option value="DOR ARTICULAR">Dor Articular</option>
                                <option value="OUTROS">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="indicacao_cob_especial" class="form-label">90 - Indicação de Cobertura
                                Especial</label>
                            <select class="form-select" id="indicacao_cob_especial"
                                name="indicacao_cob_especial">
                                <option value="">Selecione</option>
                                <option value="0"
                                    {{ old('indicacao_cob_especial', $guiaSadt->indicacao_cob_especial) == '0' ? 'selected' : '' }}>Não
                                </option>
                                <option value="1"
                                    {{ old('indicacao_cob_especial', $guiaSadt->indicacao_cob_especial) == '1' ? 'selected' : '' }}>Sim
                                </option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="space">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Adicionar</th>
                                        <th>24 - Tabela</th>
                                        <th>25 - Código</th>
                                        <th>26 - Descrição</th>
                                        <th>27 - Qtde Sol.</th>
                                        <th>28 - Qtde Aut.</th>
                                        <th colspan="3" style="text-align: center;">Ação</th>
                                    </tr>
                                </thead>
                                <tbody id="exame-table-body">
                                    @foreach ($exameSoli as $item)
                                    <tr style="text-align: center;">
                                    <td>
                                        <button type="button" class="btn btn-primary form-control"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalProcedimento1"
                                                onclick="setRowContext(this, '{{ $guiaSadt->paciente_id }}')">
                                            <i class="bi bi-list"></i>
                                        </button>
                                    </td>
                                        <td>
                                            <input class="form-control" style="text-align: center;" name="agenda_id2[]" type="hidden" value="{{$item->agenda_id}}" readonly>
                                            <input class="form-control" style="text-align: center;" name="tabela[]" type="text" value="{{$item->tabela}}" readonly>
                                        </td>
                                        <td><input class="form-control" id="codigo_procedimento_solicitado" name="codigo_procedimento_solicitado[]" type="text" value="{{$item->codigo_procedimento_solicitado}}" readonly></td>
                                        <td><input class="form-control" id="descricao_procedimento" name="descricao_procedimento[]" type="text" value="{{$item->descricao_procedimento}}" readonly></td>
                                        <td><input class="form-control" style="text-align: center;" name="qtd_sol[]" type="number" value="{{$item->qtd_sol}}"></td>
                                        <td><input class="form-control" style="text-align: center;" name="qtd_aut[]" type="number" value="{{$item->qtd_aut}}"></td>
                                        <td><button type="button" class="btn btn-danger btn-sm" onclick="excluirLinha(this)"><i class="icon bi bi-trash"></i></button></td>
                                        <td><button type="button" class="btn btn-success" onclick="adicionarNovaLinha()">+</button> </td>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h5>Dados do Contratado Executante</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="codigo_operadora_executante" class="form-label">29 - Código na
                                Operadora</label>
                            <input class="form-control" id="codigo_operadora_executante"
                                name="codigo_operadora_executante" type="text"
                                value="{{ old('codigo_operadora_executante', $guiaSadt->codigo_operadora_executante) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="nome_contratado_executante" class="form-label">30 - Nome do
                                Contratado</label>
                            <input class="form-control" id="nome_contratado_executante"
                                name="nome_contratado_executante" type="text"
                                value="{{ old('nome_contratado_executante', $guiaSadt->nome_contratado_executante) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="codigo_cnes" class="form-label">31 - Código CNES</label>
                            <input class="form-control" id="codigo_cnes" name="codigo_cnes" type="text"
                                value="{{ old('codigo_cnes', $guiaSadt->codigo_cnes) }}">
                        </div>
                    </div>
                    <hr>
                    <h5>Dados do Atendimento</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="tipo_atendimento" class="form-label">32 - Tipo de Atendimento</label>
                            <select class="form-select" id="tipo_atendimento" name="tipo_atendimento">
                                <option value="" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) ? '' : 'selected' }}>Selecione</option>
                                <option value="01" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '01' ? 'selected' : '' }}>Remoção</option>
                                <option value="02" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '02' ? 'selected' : '' }}>Pequena Cirurgia</option>
                                <option value="03" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '03' ? 'selected' : '' }}>Outras Terapias</option>
                                <option value="04" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '04' ? 'selected' : '' }}>Consulta</option>
                                <option value="05" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '05' ? 'selected' : '' }}>Exame Ambulatorial</option>
                                <option value="06" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '06' ? 'selected' : '' }}>Atendimento Domiciliar</option>
                                <option value="07" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '07' ? 'selected' : '' }}>Internação</option>
                                <option value="08" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '08' ? 'selected' : '' }}>Quimioterapia</option>
                                <option value="09" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '09' ? 'selected' : '' }}>Radioterapia</option>
                                <option value="10" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '10' ? 'selected' : '' }}>Terapia Renal Substitutiva (TRS)</option>
                                <option value="11" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '11' ? 'selected' : '' }}>Pronto Socorro</option>
                                <option value="13" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '13' ? 'selected' : '' }}>Pequeno atendimento (sutura, gesso e outros)</option>
                                <option value="14" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '14' ? 'selected' : '' }}>Saúde Ocupacional - Admissional</option>
                                <option value="15" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '15' ? 'selected' : '' }}>Saúde Ocupacional - Demissional</option>
                                <option value="16" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '16' ? 'selected' : '' }}>Saúde Ocupacional - Periódico</option>
                                <option value="17" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '17' ? 'selected' : '' }}>Saúde Ocupacional - Retorno ao trabalho</option>
                                <option value="18" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '18' ? 'selected' : '' }}>Saúde Ocupacional - Mudança de função</option>
                                <option value="19" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '19' ? 'selected' : '' }}>Saúde Ocupacional - Promoção à saúde</option>
                                <option value="20" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '20' ? 'selected' : '' }}>Saúde Ocupacional - Beneficiário novo</option>
                                <option value="21" {{ old('tipo_atendimento', $guiaSadt->tipo_consulta) == '21' ? 'selected' : '' }}>Saúde Ocupacional - Assistência a demitidos</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="indicacao_acidente" class="form-label">33 - Indicação de Acidente</label>
                            <select class="form-select" id="indicacao_acidente" name="indicacao_acidente">
                                <option value="" {{ old('indicacao_acidente', $guiaSadt->tipo_consulta) ? '' : 'selected' }}>Selecione</option>
                                <option value="1" {{ old('indicacao_acidente', $guiaSadt->tipo_consulta) == '1' ? 'selected' : '' }}>Sim</option>
                                <option value="2" {{ old('indicacao_acidente', $guiaSadt->tipo_consulta) == '2' ? 'selected' : '' }}>Não</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="tipo_consulta" class="form-label">34 - Tipo de Consulta</label>
                            <select class="form-select" id="tipo_consulta" name="tipo_consulta">
                                <option value="" {{ old('tipo_consulta', $guiaSadt->tipo_consulta) ? '' : 'selected' }}>Selecione</option>
                                <option value="1" {{ old('tipo_consulta', $guiaSadt->tipo_consulta) == '1' ? 'selected' : '' }}>Primeira Consulta</option>
                                <option value="2" {{ old('tipo_consulta', $guiaSadt->tipo_consulta) == '2' ? 'selected' : '' }}>Retorno</option>
                                <option value="3" {{ old('tipo_consulta', $guiaSadt->tipo_consulta) == '3' ? 'selected' : '' }}>Pré-natal</option>
                                <option value="4" {{ old('tipo_consulta', $guiaSadt->tipo_consulta) == '4' ? 'selected' : '' }}>Por encaminhamento</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="motivo_encerramento" class="form-label">35 - Encerramento Atend.</label>
                            <select class="form-select" id="motivo_encerramento" name="motivo_encerramento">
                                <!-- Verificação se o valor está vazio e se deve exibir "Selecione" -->
                                <option value="" disabled {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) ? '' : 'selected' }}>
                                    Selecione
                                </option>
                                <!-- Verificação de cada opção com base no valor vindo do banco ou do 'old()' -->
                                <option value="11" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '11' ? 'selected' : '' }}>Alta Curado</option>
                                <option value="12" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '12' ? 'selected' : '' }}>Alta Melhorado</option>
                                <option value="14" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '14' ? 'selected' : '' }}>Alta a pedido</option>
                                <option value="15" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '15' ? 'selected' : '' }}>
                                    Alta com previsão de retorno para acompanhamento do paciente
                                </option>
                                <option value="16" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '16' ? 'selected' : '' }}>Alta por Evasão</option>
                                <option value="18" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '18' ? 'selected' : '' }}>Alta por outros motivos</option>
                                <option value="21" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '21' ? 'selected' : '' }}>
                                    Permanência, por características próprias da doença
                                </option>
                                <option value="22" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '22' ? 'selected' : '' }}>Permanência, por intercorrência</option>
                                <option value="23" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '23' ? 'selected' : '' }}>
                                    Permanência, por impossibilidade sócio-familiar
                                </option>
                                <option value="24" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '24' ? 'selected' : '' }}>
                                    Permanência, por processo de doação de órgãos, tecidos e células - doador vivo
                                </option>
                                <option value="25" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '25' ? 'selected' : '' }}>
                                    Permanência, por processo de doação de órgãos, tecidos e células - doador morto
                                </option>
                                <option value="26" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '26' ? 'selected' : '' }}>Permanência, por mudança de procedimento</option>
                                <option value="27" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '27' ? 'selected' : '' }}>Permanência, por reoperação</option>
                                <option value="28" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '28' ? 'selected' : '' }}>Permanência, outros motivos</option>
                                <option value="31" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '31' ? 'selected' : '' }}>Transferido para outro estabelecimento</option>
                                <option value="32" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '32' ? 'selected' : '' }}>Transferência para internação domiciliar</option>
                                <option value="41" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '41' ? 'selected' : '' }}>
                                    Óbito com declaração de óbito fornecida pelo médico assistente
                                </option>
                                <option value="42" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '42' ? 'selected' : '' }}>
                                    Óbito com declaração de óbito fornecida pelo Instituto Médico Legal (IML)
                                </option>
                                <option value="43" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '43' ? 'selected' : '' }}>
                                    Óbito com declaração de óbito fornecida pelo Serviço de Verificação de Óbito (SVO)
                                </option>
                                <option value="51" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '51' ? 'selected' : '' }}>Encerramento Administrativo</option>
                                <option value="61" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '61' ? 'selected' : '' }}>Alta da mãe/puérpera e do recém-nascido</option>
                                <option value="62" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '62' ? 'selected' : '' }}>Alta da mãe/puérpera e permanência do recém-nascido</option>
                                <option value="63" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '63' ? 'selected' : '' }}>Alta da mãe/puérpera e óbito do recém-nascido</option>
                                <option value="64" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '64' ? 'selected' : '' }}>Alta da mãe/puérpera com óbito fetal</option>
                                <option value="65" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '65' ? 'selected' : '' }}>Óbito da gestante e do concepto</option>
                                <option value="66" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '66' ? 'selected' : '' }}>Óbito da mãe/puérpera e alta do recém-nascido</option>
                                <option value="67" {{ old('motivo_encerramento', $guiaSadt->motivo_encerramento) == '67' ? 'selected' : '' }}>Óbito da mãe/puérpera e permanência do recém-nascido</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="regime_atendimento" class="form-label">91 - Regime Atendimento</label>
                            <select class="form-select" id="regime_atendimento" name="regime_atendimento">
                                <option value="" disabled {{ old('regime_atendimento', $guiaSadt->regime_atendimento) ? '' : 'selected' }}>
                                    Selecione
                                </option>
                                <option value="01" {{ old('regime_atendimento', $guiaSadt->regime_atendimento) == '01' ? 'selected' : '' }}>Ambulatórial</option>
                                <option value="02" {{ old('regime_atendimento', $guiaSadt->regime_atendimento) == '02' ? 'selected' : '' }}>Emergência</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="saude_ocupacional" class="form-label">92 - Saúde Ocupacional</label>
                            <select class="form-select" id="saude_ocupacional" name="saude_ocupacional">
                                <option value="" disabled {{ old('saude_ocupacional', $guiaSadt->saude_ocupacional) ? '' : 'selected' }}>
                                    Selecione
                                </option>
                                <option value="1" {{ old('saude_ocupacional', $guiaSadt->saude_ocupacional) == '1' ? 'selected' : '' }}>Sim</option>
                                <option value="2" {{ old('saude_ocupacional', $guiaSadt->saude_ocupacional) == '2' ? 'selected' : '' }}>Não</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h5>Dados da Execução/Procedimentos e Exames Realizados</h5>
                    <div class="row">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped"
                                style="text-align: center; white-space: nowrap; font-size: 12px; min-width: 1800px; vertical-align: middle;">
                                <thead>
                                    <tr>
                                        <th>36 - Data</th>
                                        <th>37 - Hora Inicial</th>
                                        <th>38 - Hora Final</th>
                                        <th>39 - Tab.</th>
                                        <th>40 - Código</th>
                                        <th>41 - Descrição</th>
                                        <th>42 - Qtd.</th>
                                        <th>43 - Via</th>
                                        <th>44 - Tec.</th>
                                        <th>45 - Fator Red./ Acrés</th>
                                        <th>46 - Valor Unit.</th>
                                        <th>47 - Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody id="procedimento-table-body">
                                    @foreach ($exameAut as $item)
                                        <tr>
                                            <td><input class="form-control" id="data_real" name="data_real[]" type="date"  value="{{$item->data_real}}"></td>
                                            <td><input class="form-control" id="hora_inicio_atendimento" name="hora_inicio_atendimento[]" type="text"  value="{{$item->hora_inicio_atendimento}}"></td>
                                            <td><input class="form-control" id="hora_fim_atendimento" name="hora_fim_atendimento[]" type="text"  value="{{$item->hora_fim_atendimento}}"></td>
                                            <td><input class="form-control" id="tabela" name="tabela[]" type="text"  value="22"></td>
                                            <td><input class="form-control" id="codigo_procedimento_realizado" name="codigo_procedimento_realizado[]"  type="text" value="{{$item->codigo_procedimento_realizado}}"></td>
                                            <td><input class="form-control" id="descricao_procedimento_realizado" name="descricao_procedimento_realizado[]"  type="text" value="{{$item->descricao_procedimento_realizado}}"></td>
                                            <td><input class="form-control quantidade_autorizada" id="quantidade_autorizada" name="quantidade_autorizada[]" value="{{$item->quantidade_autorizada}}" type="number" oninput="calcularValorTotal(this)" placeholder="Qtd"></td>
                                            <td>
                                                <select class="form-control" id="via" name="via[]">
                                                    <option value="">{{ old('via',$item->via) ? 'selected' : 'Selecione' }}
                                                    <option value="1">Unidade</option>
                                                    <option value="2">Múltiplo</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" id="tecnica" name="tecnica[]">
                                                    <option value="">{{ old('tecnica',$item->tecnica) ? 'selected' : 'Selecione' }}
                                                    <option value="U">Unilateral</option>
                                                    <option value="B">Bilateral</option>
                                                    <option value="M">Múltiplo</option>
                                                    <option value="S">Simples</option>
                                                    <option value="C">Complexo</option>
                                                    <option value="A">Avançado</option>
                                                </select>
                                            </td>
                                            <td><input class="form-control" name="fator_red_acres[]" id="fator_red_acres" type="text" oninput="calcularValorTotal(this)" placeholder="EX:1,00" value="{{$item->fator_red_acres}}"></td>
                                            <td><input class="form-control valor_unitario" id="valor_unitario" oninput="calcularValorTotal(this)" name="valor_unitario[]" type="text" value="{{$item->valor_unitario}}"></td>
                                            <td><input class="form-control valor_total" id="valor_total" name="valor_total[]" type="text" value="{{$item->valor_total}}" placeholder="Valor Total"></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h5>Identificação do(s) profissional(is) Executante(s)</h5>
                    <div class="row">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>48 - Seq. Ref</th>
                                        <th>49 - Grau Part</th>
                                        <th>Selecione o Profissional</th>
                                        <th>50 - Cód. Operadora/CPF</th>
                                        <th>51 - Profissional</th>
                                        <th>52 - Conselho</th>
                                        <th>53 - Nº Conselho</th>
                                        <th>54 - UF</th>
                                        <th>55 - CBO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input class="form-control" name="sequencia" type="text"
                                                value="1" readonly></td>
                                        <td>
                                            <select id="grau" name="grau" class="form-control">
                                                    <option value="">{{ old('grau', $guiaSadt->grau) ? old('grau', $guiaSadt->grau) : 'Selecione' }}</option>
                                                <option value="12">Médico principal ou responsável pelo
                                                    procedimento</option>
                                                <option value="13">Assistente</option>
                                                <option value="14">Anestesista</option>
                                                <option value="15">Cirurgião Auxiliar</option>
                                                <option value="16">Técnico em Enfermagem</option>
                                                <option value="17">Fisioterapeuta</option>
                                                <option value="18">Outro Profissional</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary form-control"
                                                data-bs-toggle="modal" data-bs-target="#modalProfissional1">
                                                <i class="bi bi-list"></i>
                                            </button>
                                        </td>
                                        <td><input class="form-control" name="codigo_operadora_profissional"
                                                id="codigo_operadora_profissional" type="text" value="{{$guiaSadt->codigo_operadora_profissional}}"
                                                readonly></< /td>
                                        <td><input class="form-control" id="nome_profissional"
                                                name="nome_profissional" type="text" value="{{$guiaSadt->nome_profissional}}" readonly title="{{$guiaSadt->nome_profissional}}">
                                            </td>
                                        <td>
                                            <select name="sigla_conselho" id="sigla_conselho" class="form-select">
                                                <option value="" disabled selected>Selecione</option>
                                                @foreach ($conselhos as $sigla => $codigo)
                                                    <option value="{{ $codigo }}"
                                                        {{ old('sigla_conselho', $guiaSadt->sigla_conselho) == $codigo ? 'selected' : '' }}>
                                                        {{ $sigla }} <!-- Exibe a sigla -->
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input class="form-control" name="numero_conselho_profissional"
                                                id="numero_conselho_profissional" type="text" value="{{$guiaSadt->numero_conselho_profissional}}"
                                                readonly></td>
                                        <td>
                                            <select name="uf_profissional" id="uf_profissional" class="form-select">
                                                <option value="" disabled selected>Selecione</option>
                                                @foreach ($ufs as $uf => $codigo)
                                                    <option value="{{ $codigo }}"
                                                        {{ old('uf_profissional', $guiaSadt->uf_profissional) == $codigo ? 'selected' : '' }}>
                                                        {{ $uf }} <!-- Exibe a sigla -->
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input class="form-control" name="codigo_cbo_profissional"
                                                id="codigo_cbo_profissional" type="text" value="{{$guiaSadt->codigo_cbo_profissional}}"
                                                readonly></< /td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-control" name="sequencia1" type="text"
                                                value="2" readonly></td>
                                        <td>
                                            <select id="grau1" name="grau1" class="form-control">
                                                    <option value="">{{ old('grau1', $guiaSadt->grau1) ? old('grau1', $guiaSadt->grau1) : 'Selecione' }}</option>
                                                <option value="12">Médico principal ou responsável pelo
                                                    procedimento</option>
                                                <option value="13">Assistente</option>
                                                <option value="14">Anestesista</option>
                                                <option value="15">Cirurgião Auxiliar</option>
                                                <option value="16">Técnico em Enfermagem</option>
                                                <option value="17">Fisioterapeuta</option>
                                                <option value="18">Outro Profissional</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary form-control"
                                                data-bs-toggle="modal" data-bs-target="#modalProfissional2">
                                                <i class="bi bi-list"></i>
                                            </button>
                                        </td>
                                        <td><input class="form-control" name="codigo_operadora_profissional1"
                                                id="codigo_operadora_profissional1" type="text" value="{{$guiaSadt->codigo_operadora_profissional1}}"
                                                readonly></< /td>
                                        <td>
                                            <input class="form-control" id="nome_profissional1"
                                                name="nome_profissional1" type="text" value="{{$guiaSadt->nome_profissional1}}" readonly title="{{$guiaSadt->nome_profissional1}}">
                                        </td>
                                        <td>
                                            <select name="sigla_conselho1" id="sigla_conselho1" class="form-select">
                                                <option value="" disabled selected>Selecione</option>
                                                @foreach ($conselhos as $sigla => $codigo)
                                                    <option value="{{ $codigo }}"
                                                        {{ old('sigla_conselho1', $guiaSadt->sigla_conselho1) == $codigo ? 'selected' : '' }}>
                                                        {{ $sigla }} <!-- Exibe a sigla -->
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input class="form-control" name="numero_conselho_profissional1"
                                                id="numero_conselho_profissional1" type="text" value="{{$guiaSadt->numero_conselho_profissional1}}"
                                                readonly></td>
                                        <td><select name="uf_profissional1" id="uf_profissional1" class="form-select">
                                            <option selected disabled>Selecione</option>
                                            @foreach ($ufs as $uf => $codigo)
                                                <option value="{{ $codigo }}"
                                                    {{ old('uf_profissional1', $guiaSadt->uf_profissional1) == $codigo ? 'selected' : '' }}>
                                                    {{ $uf }}
                                                </option>
                                            @endforeach
                                        </select>
                                        </td>
                                        <td><input class="form-control" name="codigo_cbo_profissional1"
                                                id="codigo_cbo_profissional1" type="text" value="{{$guiaSadt->codigo_cbo_profissional1}}"
                                                readonly></< /td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input class="form-control" name="sequencia2" type="text"
                                                value="3" readonly></td>
                                        <td>
                                            <select id="grau2" name="grau2" class="form-control">
                                                <option value="">{{ old('grau2', $guiaSadt->grau2) ? old('grau2', $guiaSadt->grau2) : 'Selecione' }}</option>
                                                <option value="12">Médico principal ou responsável pelo procedimento</option>
                                                <option value="13">Assistente</option>
                                                <option value="14">Anestesista</option>
                                                <option value="15">Cirurgião Auxiliar</option>
                                                <option value="16">Técnico em Enfermagem</option>
                                                <option value="17">Fisioterapeuta</option>
                                                <option value="18">Outro Profissional</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary form-control"
                                                data-bs-toggle="modal" data-bs-target="#modalProfissional3">
                                                <i class="bi bi-list"></i>
                                            </button>
                                        </td>
                                        <td><input class="form-control" name="codigo_operadora_profissional2"
                                                id="codigo_operadora_profissional2" type="text" value="{{$guiaSadt->codigo_operadora_profissional2}}"
                                                readonly></< /td>
                                        <td><input class="form-control" id="nome_profissional2"
                                                name="nome_profissional2" type="text" value="{{$guiaSadt->nome_profissional2}}" readonly title="{{$guiaSadt->nome_profissional2}}">
                                        </td>
                                        <td>
                                            <select name="sigla_conselho2" id="sigla_conselho2" class="form-select">
                                                <option value="" disabled selected>Selecione</option>
                                                @foreach ($conselhos as $sigla => $codigo)
                                                    <option value="{{ $codigo }}"
                                                        {{ old('sigla_conselho2', $guiaSadt->sigla_conselho2) == $codigo ? 'selected' : '' }}>
                                                        {{ $sigla }} <!-- Exibe a sigla -->
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input class="form-control" name="numero_conselho_profissional2"
                                                id="numero_conselho_profissional2" type="text" value="{{$guiaSadt->numero_conselho_profissional2}}"
                                                readonly></td>
                                        <td><select name="uf_profissional2" id="uf_profissional2" class="form-select">
                                            <option selected disabled>Selecione</option>
                                            @foreach ($ufs as $uf => $codigo)
                                                <option value="{{ $codigo }}"
                                                    {{ old('uf_profissional2', $guiaSadt->uf_profissional2) == $codigo ? 'selected' : '' }}>
                                                    {{ $uf }}
                                                </option>
                                            @endforeach
                                        </select></td>
                                        <td><input class="form-control" name="codigo_cbo_profissional2"
                                                id="codigo_cbo_profissional2" type="text" value="{{$guiaSadt->codigo_cbo_profissional2}}"
                                                readonly></< /td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h5>Despesas Realizadas</h5>
                    <div class="row">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped"
                                style="text-align: center; white-space: nowrap; font-size: 12px; min-width: 1800px; vertical-align: middle;">
                                <thead>
                                    <tr>
                                        <th>6 - CD</th>
                                        <th>7 - Data</th>
                                        <th>8 - Hora inicial</th>
                                        <th>9 - Hora Final</th>
                                        <th>10 - Tabela</th>
                                        <th>17 - Descrição</th>
                                        <th>11 - Código do Ítem</th>
                                        <th>12 - Qtd</th>
                                        <th>13 - Unid de Medida </th>
                                        <th>14 - Fator Red./Acresc.</th>
                                        <th>15 - Valor Unitário</th>
                                        <th>16 - Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody id="medicamentos-table-body">
                                </tbody>
                                <tbody id="materiais-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="observacao" class="form-label">58- Observação / Justificativa</label>
                            <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao', $guiaSadt->observacao) }}</textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="saveButton" class="btn btn-primary" type="submit">
                            <i class="bi bi-check-circle-fill me-2"></i>Salvar
                        </button>
                    </div>
                </div>

                <button id="gerarGuiaSADTButton" class="btn btn-danger d-none">
                    <i class="bi bi-file-earmark-break"></i> Gerar Guia SADT
                </button>
            </form>
        </div>
    </div>
</main>

<div class="modal fade" id="modalProcedimento1" tabindex="-1" aria-labelledby="modalProcedimentoLabel1" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 50%; margin: 1.75rem auto;">
        <div class="modal-content" style="max-height: calc(100vh - 3.5rem); overflow-y: auto; overflow-x: hidden;">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProcedimentoLabel1">Selecione o Procedimento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: 70vh;">
                <div class="mb-3">
                    <input class="form-control" id="procSearch" type="text" placeholder="Pesquisar por Código ou Procedimento...">
                </div>
                <input type="hidden" id="hiddenAgendaId" name="agendaId">
                <table class="table table-hover" id="procTable">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Procedimento</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="procTableBody">
                        <!-- Procedimentos serão carregados aqui -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProfissional1" tabindex="-1" aria-labelledby="modalProfissionalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProfissionalLabel1">Selecione o Profissional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input class="form-control" id="profSearch" type="text"
                                placeholder="Pesquisar por nome ou CPF...">
                        </div>
                        <table class="table table-hover" id="profTable">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profissionals as $p)
                                    <tr>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->cpf }}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectProfissional1('{{ $p->name }}', '{{ $p->cbo }}', '{{ $p->conselho_1 }}', '{{ $p->uf_conselho_1 }}', '{{ $p->cpf }}', '{{ $p->conselho_profissional }}')">Selecionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalProfissional2" tabindex="-1" aria-labelledby="modalProfissionalLabel2"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProfissionalLabel2">Selecione o Profissional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input class="form-control" id="profSearch" type="text"
                                placeholder="Pesquisar por nome ou CPF...">
                        </div>
                        <table class="table table-hover" id="profTable">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profissionals as $p)
                                    <tr>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->cpf }}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectProfissional2('{{ $p->name }}', '{{ $p->cbo }}', '{{ $p->conselho_1 }}', '{{ $p->uf_conselho_1 }}', '{{ $p->cpf }}', '{{ $p->conselho_profissional }}')">Selecionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalProfissional3" tabindex="-1" aria-labelledby="modalProfissionalLabel3"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalProfissionalLabel3">Selecione o Profissional</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input class="form-control" id="profSearch" type="text"
                                placeholder="Pesquisar por nome ou CPF...">
                        </div>
                        <table class="table table-hover" id="profTable">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profissionals as $p)
                                    <tr>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->cpf }}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectProfissional3('{{ $p->name }}', '{{ $p->cbo }}', '{{ $p->conselho_1 }}', '{{ $p->uf_conselho_1 }}', '{{ $p->cpf }}', '{{ $p->conselho_profissional }}')">Selecionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
        let activeRow = null;

            $('[id^=profSearch]').on('keyup', function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val().toLowerCase();
            var tableId = inputId.replace('Search', 'Table');
            var rows = $('#' + tableId + ' tbody tr');

            rows.each(function() {
                var name = $(this).find('td').eq(0).text().toLowerCase();
                var cpf = $(this).find('td').eq(2).text().toLowerCase();
                if (name.indexOf(inputValue) > -1 || cpf.indexOf(inputValue) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        function selectProfissional1(name, cbo, conselho_1, uf_conselho_1, cpf, conselho_profissional) {
            // Preenche os campos com os dados
            document.getElementById('nome_profissional').value = name;
            document.getElementById('sigla_conselho').value = conselho_profissional;
            document.getElementById('numero_conselho_profissional').value = conselho_1;
            document.getElementById('codigo_cbo_profissional').value = cbo;
            document.getElementById('codigo_operadora_profissional').value = cpf;

        // Agora, lidamos com a atribuição do Conselho
        const conselhos = {
            'CRAS': '01',
            'COREN': '02',
            'CRF': '03',
            'CRFA': '04',
            'CREFITO': '05',
            'CRM': '06',
            'CRN': '07',
            'CRO': '08',
            'CRP': '09',
            'OUTROS': '10'
        };

        // Se conselho_profissional for uma sigla (como "CRM"), procuramos o código
        if (Object.keys(conselhos).includes(conselho_profissional)) {
            document.getElementById('sigla_conselho').value = conselhos[conselho_profissional]; // Atribui o código correspondente
        } else {
            // Se for um código, apenas atribuimos diretamente
            document.getElementById('sigla_conselho').value = conselho_profissional;
        }
        // Agora, lidamos com a atribuição da UF
        const ufs = {
            'AC': '12', 'AL': '27', 'AP': '16', 'AM': '13',
            'BA': '29', 'CE': '23', 'DF': '53', 'ES': '32',
            'GO': '52', 'MA': '21', 'MT': '51', 'MS': '50',
            'MG': '31', 'PA': '15', 'PB': '25', 'PR': '41',
            'PE': '26', 'PI': '22', 'RJ': '33', 'RN': '24',
            'RS': '43', 'RO': '11', 'RR': '14', 'SC': '42',
            'SP': '35', 'SE': '28', 'TO': '17'
        };

        // Se uf_conselho_1 for uma sigla (2 caracteres), usamos diretamente
        if (uf_conselho_1.length == 2) {
            document.getElementById('uf_profissional').value = ufs[uf_conselho_1] || ''; // Garante que se não encontrar o código, não atribui nada
        } else {
            // Se for um código numérico, mapeamos para a sigla correspondente
            for (let uf in ufs) {
                if (ufs[uf] == uf_conselho_1) {
                    document.getElementById('uf_profissional').value = ufs[uf];
                    break;
                }
            }
        }

            // Fecha o modal de seleção de profissional
            const modalProfissional1 = bootstrap.Modal.getInstance(document.getElementById('modalProfissional1'));
            modalProfissional1.hide();
        }

        function selectProfissional2(name, cbo, conselho_1, uf_conselho_1, cpf, conselho_profissional) {
            // Preenche o campo com o nome selecionado
            document.getElementById('nome_profissional1').value = name;
            document.getElementById('sigla_conselho1').value = conselho_profissional;
            document.getElementById('numero_conselho_profissional1').value = conselho_1;
            document.getElementById('codigo_cbo_profissional1').value = cbo;
            document.getElementById('uf_profissional1').value = uf_conselho_1;
            document.getElementById('codigo_operadora_profissional1').value = cpf;

            // Agora, lidamos com a atribuição do Conselho
            const conselhos = {
                'CRAS': '01',
                'COREN': '02',
                'CRF': '03',
                'CRFA': '04',
                'CREFITO': '05',
                'CRM': '06',
                'CRN': '07',
                'CRO': '08',
                'CRP': '09',
                'OUTROS': '10'
            };

            // Se conselho_profissional for uma sigla (como "CRM"), procuramos o código
            if (Object.keys(conselhos).includes(conselho_profissional)) {
                document.getElementById('sigla_conselho1').value = conselhos[conselho_profissional]; // Atribui o código correspondente
            } else {
                // Se for um código, apenas atribuimos diretamente
                document.getElementById('sigla_conselho1').value = conselho_profissional;
            }
            // Agora, lidamos com a atribuição da UF
            const ufs = {
                'AC': '12', 'AL': '27', 'AP': '16', 'AM': '13',
                'BA': '29', 'CE': '23', 'DF': '53', 'ES': '32',
                'GO': '52', 'MA': '21', 'MT': '51', 'MS': '50',
                'MG': '31', 'PA': '15', 'PB': '25', 'PR': '41',
                'PE': '26', 'PI': '22', 'RJ': '33', 'RN': '24',
                'RS': '43', 'RO': '11', 'RR': '14', 'SC': '42',
                'SP': '35', 'SE': '28', 'TO': '17'
            };

            // Se uf_conselho_1 for uma sigla (2 caracteres), usamos diretamente
            if (uf_conselho_1.length == 2) {
                document.getElementById('uf_profissional1').value = ufs[uf_conselho_1] || ''; // Garante que se não encontrar o código, não atribui nada
            } else {
                // Se for um código numérico, mapeamos para a sigla correspondente
                for (let uf in ufs) {
                    if (ufs[uf] == uf_conselho_1) {
                        document.getElementById('uf_profissional1').value = ufs[uf];
                        break;
                    }
                }
            }

            // Fecha o modal de seleção de profissional
            const modalProfissional2 = bootstrap.Modal.getInstance(document.getElementById('modalProfissional2'));
            modalProfissional2.hide();
        }

        function selectProfissional3(name, cbo, conselho_1, uf_conselho_1, cpf, conselho_profissional) {
            // Preenche o campo com o nome selecionado
            document.getElementById('nome_profissional2').value = name;
            document.getElementById('sigla_conselho2').value = conselho_profissional;
            document.getElementById('numero_conselho_profissional2').value = conselho_1;
            document.getElementById('codigo_cbo_profissional2').value = cbo;
            document.getElementById('uf_profissional2').value = uf_conselho_1;
            document.getElementById('codigo_operadora_profissional2').value = cpf;

            // Agora, lidamos com a atribuição do Conselho
            const conselhos = {
                'CRAS': '01',
                'COREN': '02',
                'CRF': '03',
                'CRFA': '04',
                'CREFITO': '05',
                'CRM': '06',
                'CRN': '07',
                'CRO': '08',
                'CRP': '09',
                'OUTROS': '10'
            };

            // Se conselho_profissional for uma sigla (como "CRM"), procuramos o código
            if (Object.keys(conselhos).includes(conselho_profissional)) {
                document.getElementById('sigla_conselho2').value = conselhos[conselho_profissional]; // Atribui o código correspondente
            } else {
                // Se for um código, apenas atribuimos diretamente
                document.getElementById('sigla_conselho2').value = conselho_profissional;
            }
             // Agora, lidamos com a atribuição da UF
             const ufs = {
                'AC': '12', 'AL': '27', 'AP': '16', 'AM': '13',
                'BA': '29', 'CE': '23', 'DF': '53', 'ES': '32',
                'GO': '52', 'MA': '21', 'MT': '51', 'MS': '50',
                'MG': '31', 'PA': '15', 'PB': '25', 'PR': '41',
                'PE': '26', 'PI': '22', 'RJ': '33', 'RN': '24',
                'RS': '43', 'RO': '11', 'RR': '14', 'SC': '42',
                'SP': '35', 'SE': '28', 'TO': '17'
            };

            // Se uf_conselho_1 for uma sigla (2 caracteres), usamos diretamente
            if (uf_conselho_1.length == 2) {
                document.getElementById('uf_profissional2').value = ufs[uf_conselho_1] || ''; // Garante que se não encontrar o código, não atribui nada
            } else {
                // Se for um código numérico, mapeamos para a sigla correspondente
                for (let uf in ufs) {
                    if (ufs[uf] == uf_conselho_1) {
                        document.getElementById('uf_profissional2').value = ufs[uf];
                        break;
                    }
                }
            }

            // Fecha o modal de seleção de profissional
            const modalProfissional3 = bootstrap.Modal.getInstance(document.getElementById('modalProfissional3'));
            modalProfissional3.hide();
        }

        function adicionarNovaLinha() {
    let tabela = document.querySelector("table tbody");
    let novaLinha = document.createElement("tr");
    novaLinha.style.textAlign = "center";

    novaLinha.innerHTML = `
        <td>
            <button type="button" class="btn btn-primary form-control"
                    data-bs-toggle="modal"
                    data-bs-target="#modalProcedimento1"
                    onclick="setRowContext(this, '{{ $guiaSadt->paciente_id }}')">
                <i class="bi bi-list"></i>
            </button>
        </td>
        <td>
            <input class="form-control" style="text-align: center;" name="agenda_id2[]" type="hidden" value="">
            <input class="form-control" style="text-align: center;" name="tabela[]" type="text" value="22">
        </td>
        <td><input class="form-control" id="codigo_procedimento_solicitado" name="codigo_procedimento_solicitado[]" type="text" value=""></td>
        <td><input class="form-control" id="descricao_procedimento" name="descricao_procedimento[]" type="text" value=""></td>
        <td><input class="form-control" style="text-align: center;" name="qtd_sol[]" type="number" value=""></td>
        <td><input class="form-control" style="text-align: center;" name="qtd_aut[]" type="number" value=""></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="excluirLinha(this)"><i class="icon bi bi-trash"></i></button></td>
    `;

    tabela.appendChild(novaLinha);
}

function excluirLinha(botao) {
    let linha = botao.closest("tr");
    linha.remove();
}

function setRowContext(button, pacienteId) {
    // Identifica a linha correspondente ao botão clicado
    activeRow = $(button).closest('tr');

    // Definir o valor no modal, por exemplo, em um campo hidden ou exibindo na interface
    $('#modalProcedimento1').find('#hiddenAgendaId').val(pacienteId); // Para campos hidden
    $('#modalProcedimento1').find('.agenda-display').text(pacienteId);

    if (!pacienteId) {
        alert('Paciente ID não encontrado!');
        return;
    }

    fetch(`/api/get-procedimentos/${pacienteId}`)
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('procTableBody');
            tableBody.innerHTML = '';

            if (data.length > 0) {
                data.forEach(procedimento => {
                    const row = `
                        <tr>
                            <td>${procedimento.codigo}</td>
                            <td>${procedimento.procedimento}</td>
                            <td>
                                <button class="btn btn-primary" type="button"
                                onclick="selectProcedimento1('${procedimento.id}', '${procedimento.codigo}', '${procedimento.procedimento}')">Selecionar</button>
                            </td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });
            } else {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="3" class="text-center">Nenhum procedimento disponível.</td>
                    </tr>
                `;
            }
        })
        .catch(error => {
            console.error('Erro ao buscar procedimentos:', error);
            alert('Erro ao buscar procedimentos!');
        });
}

function selectProcedimento1(id, codigo, procedimento) {
    if (activeRow) {
        // Preenche os campos da linha ativa pelos IDs
        activeRow.find('#proce_id').val(id);
        activeRow.find('#codigo_procedimento_solicitado').val(codigo);
        activeRow.find('#descricao_procedimento').val(procedimento);

        // Fecha o modal
        const modalProcedimento1 = bootstrap.Modal.getInstance(document.getElementById('modalProcedimento1'));
        modalProcedimento1.hide();

        // Opcional: Reabre outro modal, se necessário
        setTimeout(() => {
            const modalSADT = new bootstrap.Modal(document.getElementById('modalSADT'));
            modalSADT.show();
        }, 500);
    } else {
        console.error('Nenhuma linha ativa encontrada para preencher os campos.');
    }
}

// Envio do formulário Guia SADT via AJAX
$('#guiaForm2').on('submit', function(event) {
    event.preventDefault(); // Previne envio padrão

    var formData = $(this).serialize(); // Serializa os dados do formulário
    // Coleta os dados de #exame-table-body
    var exameData = [];
    $('#exame-table-body tr').each(function () {
        var linha = {
            tabela: $(this).find('input[name="tabela"]').val(),
            codigo_procedimento_solicitado: $(this).find('input[name="codigo_procedimento_solicitado"]').val(),
            descricao_procedimento: $(this).find('input[name="descricao_procedimento"]').val(),
            qtd_sol: $(this).find('input[name="qtd_sol"]').val(),
            qtd_aut: $(this).find('input[name="qtd_aut"]').val()
        };
        exameData.push(linha);
    });

    // Adiciona os dados coletados ao console para depuração
    console.log('Dados enviados (form):', formData);
    console.log('Dados enviados (exame-table-body):', exameData);

    $.ajax({
        url: '{{ route('guia.sadt.salvar') }}', // Rota para salvar guia SADT
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                alert(response.message); // Exibe mensagem de sucesso

                // Exibir o botão de "Gerar Guia"
                $('#gerarGuiaSADTButton').removeClass('d-none');
            } else {
                alert('Erro ao salvar a guia SADT: ' + response.message);
            }
        },
        error: function(xhr) {
            alert('Erro ao salvar a guia SADT.');
            console.error('Erro:', xhr.responseText);
        }
    });
});
        </script>
@endsection
