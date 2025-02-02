@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title">
        <h1><i class="bi bi-pencil"></i> Editar Guia de SADT</h1>
    </div>

    <!-- Mensagens de Sucesso e Erro -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('guia.sp.atualizar') }}">
                @csrf
                @method('POST')

                {{-- SADT Form --}}
                <div>
                    <input type="hidden" name="convenio_id" value="{{ $guiaSadt->convenio_id }}">
                    <input type="hidden" name="agenda_id" value="{{ $guiaSadt->agenda_id }}">
                    <input type="hidden" name="paciente_id" value="{{ $guiaSadt->paciente_id }}">
                    <input type="hidden" name="profissional_id" value="{{ $guiaSadt->profissional_id }}">
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
                                        <th colspan="2" class="text-center">
                                            Ação
                                            <button type="button" class="btn btn-success btn-sm" onclick="adicionarLinha()">+</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="exame-table-body">
                                    @foreach ($exameSoli as $item)
                                    <tr style="text-align: center;">
                                    <td>
                                        <button type="button" class="btn btn-primary form-control"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalProcedimento1"
                                                data-agenda-id="{{ $guiaSadt->paciente_id }}"
                                                onclick="setRow1(this, '{{ $guiaSadt->paciente_id }}')">
                                            <i class="bi bi-list"></i>
                                        </button>
                                    </td>
                                        <td>
                                            <input class="form-control" style="text-align: center;" id="agenda_id2" name="agenda_id2[]" type="hidden" value="{{$item->agenda_id}}" readonly>
                                            <input class="form-control" style="text-align: center;" name="tabela[]" type="text" value="{{$item->tabela}}" readonly>
                                        </td>
                                        <td><input class="form-control" id="codigo_procedimento_solicitado" name="codigo_procedimento_solicitado[]" type="text" value="{{$item->codigo_procedimento_solicitado}}" readonly></td>
                                        <td><input class="form-control" id="descricao_procedimento" name="descricao_procedimento[]" type="text" value="{{$item->descricao_procedimento}}" readonly></td>
                                        <td><input class="form-control" style="text-align: center;" name="qtd_sol[]" type="number" value="{{$item->qtd_sol}}"></td>
                                        <td><input class="form-control" style="text-align: center;" name="qtd_aut[]" type="number" value="{{$item->qtd_aut}}"></td>

                                        <td><button type="button" class="form-control btn btn-success" onclick="adicionarLinha()">+</button></td>
                                        <td><button type="button" class="form-control btn btn-danger" onclick="removerLinha(this)">-</button></td>
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
                                        <th>Adicionar</th>
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
                                        <th colspan="2" class="text-center">
                                            Ação
                                            <button type="button" class="btn btn-success btn-sm" onclick="adicionarLinha1()">+</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="procedimento-table-body">
                                    @foreach ($exameAut as $item)
                                        <tr>
                                            <td>
                                                <button type="button" class="btn btn-primary form-control"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalProcedimento2"
                                                        data-agenda-id="{{ $guiaSadt->paciente_id }}"
                                                        onclick="setRow2(this, '{{ $guiaSadt->paciente_id }}')">
                                                    <i class="bi bi-list"></i>
                                                </button>
                                            </td>
                                            <td><input style="width: 119px;" class="form-control" name="data_real[]" type="text" value="{{ $item->data_real ? \Carbon\Carbon::parse($item->data_real)->format('d/m/Y') : '' }}"></td>
                                            <td><input class="form-control" id="hora_inicio_atendimento" name="hora_inicio_atendimento[]" type="text"  value="{{$item->hora_inicio_atendimento}}"></td>
                                            <td><input class="form-control" id="hora_fim_atendimento" name="hora_fim_atendimento[]" type="text"  value="{{$item->hora_fim_atendimento}}"></td>
                                            <td><input class="form-control" id="tabela" name="tabela[]" type="text"  value="22"></td>
                                            <td><input class="form-control" id="codigo_procedimento_realizado" name="codigo_procedimento_realizado[]"  type="text" value="{{$item->codigo_procedimento_realizado}}"></td>
                                            <td><input class="form-control" id="descricao_procedimento_realizado" name="descricao_procedimento_realizado[]"  type="text" value="{{$item->descricao_procedimento_realizado}}"></td>
                                            <td><input class="form-control quantidade_autorizada" id="quantidade_autorizada" name="quantidade_autorizada[]" value="{{$item->quantidade_autorizada}}" type="number" oninput="calcularValorTotal(this)" placeholder="Qtd"></td>
                                            <td>
                                                <select class="form-control" id="via" name="via[]">
                                                    <option value="" {{ old("via.$loop->index", $item->via) == '' ? 'selected' : '' }}>Selecione</option>
                                                    <option value="1" {{ old("via.$loop->index", $item->via) == 1 ? 'selected' : '' }}>Unidade</option>
                                                    <option value="2" {{ old("via.$loop->index", $item->via) == 2 ? 'selected' : '' }}>Múltiplo</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" id="tecnica" name="tecnica[]">
                                                    <option value="" {{ old("tecnica.$loop->index", $item->tecnica) == '' ? 'selected' : '' }}>Selecione</option>
                                                    <option value="U" {{ old("tecnica.$loop->index", $item->tecnica) == 'U' ? 'selected' : '' }}>Unilateral</option>
                                                    <option value="B" {{ old("tecnica.$loop->index", $item->tecnica) == 'B' ? 'selected' : '' }}>Bilateral</option>
                                                    <option value="M" {{ old("tecnica.$loop->index", $item->tecnica) == 'M' ? 'selected' : '' }}>Múltiplo</option>
                                                    <option value="S" {{ old("tecnica.$loop->index", $item->tecnica) == 'S' ? 'selected' : '' }}>Simples</option>
                                                    <option value="C" {{ old("tecnica.$loop->index", $item->tecnica) == 'C' ? 'selected' : '' }}>Complexo</option>
                                                    <option value="A" {{ old("tecnica.$loop->index", $item->tecnica) == 'A' ? 'selected' : '' }}>Avançado</option>
                                                </select>
                                            </td>
                                            <td><input class="form-control" name="fator_red_acres[]" id="fator_red_acres" type="text" oninput="calcularValorTotal(this)" placeholder="EX:1,00" value="{{$item->fator_red_acres}}"></td>
                                            <td><input class="form-control valor_unitario" id="valor_unitario" oninput="calcularValorTotal(this)" name="valor_unitario[]" type="text" value="{{$item->valor_unitario}}"></td>
                                            <td><input class="form-control valor_total" id="valor_total" name="valor_total[]" type="text" value="{{$item->valor_total}}" placeholder="Valor Total"></td>
                                            <td><button type="button" class="form-control btn btn-success" onclick="adicionarLinha1()">+</button></td>
                                            <td><button type="button" class="form-control btn btn-danger" onclick="removerLinha1(this)">-</button></td>
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
                                                <option value="">{{ old('grua', $guiaSadt->grua) ? old('grua', $guiaSadt->grua) : 'Selecione' }}</option>
                                                <option value="12" {{ old('grua', $guiaSadt->grua) == '12' ? 'selected' : '' }}>Médico principal ou responsável pelo procedimento</option>
                                                <option value="13" {{ old('grua', $guiaSadt->grua) == '13' ? 'selected' : '' }}>Assistente</option>
                                                <option value="14" {{ old('grua', $guiaSadt->grua) == '14' ? 'selected' : '' }}>Anestesista</option>
                                                <option value="15" {{ old('grua', $guiaSadt->grua) == '15' ? 'selected' : '' }}>Cirurgião Auxiliar</option>
                                                <option value="16" {{ old('grua', $guiaSadt->grua) == '16' ? 'selected' : '' }}>Técnico em Enfermagem</option>
                                                <option value="17" {{ old('grua', $guiaSadt->grua) == '17' ? 'selected' : '' }}>Fisioterapeuta</option>
                                                <option value="18" {{ old('grua', $guiaSadt->grua) == '18' ? 'selected' : '' }}>Outro Profissional</option>
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
                                                <option value="" {{ old('grau1', $guiaSadt->grau1) == '' ? 'selected' : '' }}>Selecione</option>
                                                <option value="12" {{ old('grau1', $guiaSadt->grau1) == '12' ? 'selected' : '' }}>Médico principal ou responsável pelo procedimento</option>
                                                <option value="13" {{ old('grau1', $guiaSadt->grau1) == '13' ? 'selected' : '' }}>Assistente</option>
                                                <option value="14" {{ old('grau1', $guiaSadt->grau1) == '14' ? 'selected' : '' }}>Anestesista</option>
                                                <option value="15" {{ old('grau1', $guiaSadt->grau1) == '15' ? 'selected' : '' }}>Cirurgião Auxiliar</option>
                                                <option value="16" {{ old('grau1', $guiaSadt->grau1) == '16' ? 'selected' : '' }}>Técnico em Enfermagem</option>
                                                <option value="17" {{ old('grau1', $guiaSadt->grau1) == '17' ? 'selected' : '' }}>Fisioterapeuta</option>
                                                <option value="18" {{ old('grau1', $guiaSadt->grau1) == '18' ? 'selected' : '' }}>Outro Profissional</option>
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
                                                <option value="12" {{ old('grau2', $guiaSadt->grau2) == '12' ? 'selected' : '' }}>Médico principal ou responsável pelo procedimento</option>
                                                <option value="13" {{ old('grau2', $guiaSadt->grau2) == '13' ? 'selected' : '' }}>Assistente</option>
                                                <option value="14" {{ old('grau2', $guiaSadt->grau2) == '14' ? 'selected' : '' }}>Anestesista</option>
                                                <option value="15" {{ old('grau2', $guiaSadt->grau2) == '15' ? 'selected' : '' }}>Cirurgião Auxiliar</option>
                                                <option value="16" {{ old('grau2', $guiaSadt->grau2) == '16' ? 'selected' : '' }}>Técnico em Enfermagem</option>
                                                <option value="17" {{ old('grau2', $guiaSadt->grau2) == '17' ? 'selected' : '' }}>Fisioterapeuta</option>
                                                <option value="18" {{ old('grau2', $guiaSadt->grau2) == '18' ? 'selected' : '' }}>Outro Profissional</option>
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
                            <table class="table table-striped">
                            <thead>
                                    <tr>
                                        <th colspan="15" style="text-align: center; font-size: 16px; font-weight: bold;">Medicamentos</th>
                                    </tr>
                                    <tr>
                                        <th>Adicionar</th>
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
                                        <th colspan="2" class="text-center">
                                            Ação
                                            <button type="button" class="btn btn-success btn-sm" onclick="adicionarLinha2()">+</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="medicamentos-table-body">
                                    @foreach ($medicamentos as $medicamento)
                                        <tr>
                                            @if(is_object($medicamento))
                                                <td>
                                                    <button type="button" class="btn btn-primary form-control"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalProcedimento3"
                                                            data-agenda-id="{{ $guiaSadt->paciente_id }}"
                                                            onclick="setRow3(this, '{{ $guiaSadt->paciente_id }}')">
                                                        <i class="bi bi-list"></i>
                                                    </button>
                                                </td>
                                                <td><input style="width: 50px;" class="form-control" name="cd[]" type="text" value="{{ $medicamento->cd ?? '' }}">
                                                    <input style="width: 50px;" class="form-control" name="medicamento_id[]" type="hidden" value="{{ $medicamento->medicamento_id ?? '' }}"></td>
                                                <td><input style="width: 119px;" class="form-control" name="created_at[]" type="text" value="{{ $medicamento->created_at ? \Carbon\Carbon::parse($medicamento->created_at)->format('d/m/Y') : '' }}"></td>
                                                <td><input class="form-control" type="text" name="hora_inicial[]" value="{{ $medicamento->created_at ? \Carbon\Carbon::parse($medicamento->created_at)->format('H:i:s') : '' }}"></td>
                                                <td><input class="form-control" type="text" name="hora_final[]" value="{{ $medicamento->created_at ? \Carbon\Carbon::parse($medicamento->created_at)->format('H:i:s') : '' }}"></td>
                                                <td><input class="form-control" type="text" name="tabela[]" value="{{ $medicamento->tabela ?? '' }}"></td>
                                                <td><input class="form-control" name="nome_medicamento[]" type="text" value="{{ $medicamento->nome_medicamento ?? '' }}"></td>
                                                <td><input class="form-control" name="codigo[]" id="codigo" type="text" value="{{ $medicamento->codigo ?? '' }}"></td>
                                                <td><input class="form-control quantidade" name="quantidade[]" type="number" value="{{ $medicamento->quantidade ?? '' }}"></td>
                                                <td>
                                                    <select name="unidade_medida[]" class="form-control">
                                                        <option value="">Selecione</option>
                                                        <option value="001" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '001' ? 'selected' : '' }}>Unidade</option>
                                                        <option value="002" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '002' ? 'selected' : '' }}>Caixa</option>
                                                        <option value="003" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '003' ? 'selected' : '' }}>Frasco</option>
                                                        <option value="004" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '004' ? 'selected' : '' }}>Ampola</option>
                                                        <option value="005" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '005' ? 'selected' : '' }}>Comprimido</option>
                                                        <option value="006" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '006' ? 'selected' : '' }}>Gotas</option>
                                                        <option value="007" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '007' ? 'selected' : '' }}>Mililitro (ml)</option>
                                                        <option value="008" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '008' ? 'selected' : '' }}>Grama (g)</option>
                                                        <option value="036" {{ old('unidade_medida', $medicamento->unidade_medida ?? '') == '036' ? 'selected' : '' }}>Outros</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control fator" name="fator[]" type="text" value="{{ $medicamento->fator ?? '' }}"></td>
                                                <td><input class="form-control valor" name="valor[]" type="text" value="{{ $medicamento->valor ?? '' }}"></td>
                                                <td><input class="form-control valor_total" name="valor_total[]" type="text" value="{{ $medicamento->valor_total ?? '' }}"></td>
                                                <td><button type="button" class="form-control btn btn-success" onclick="adicionarLinha2()">+</button></td>
                                                <td><button type="button" class="form-control btn btn-danger" onclick="removerLinha2(this)">-</button></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th colspan="15" style="text-align: center; font-size: 16px; font-weight: bold;">Materias</th>
                                    </tr>
                                    <tr>
                                        <th>Adicionar</th>
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
                                        <th colspan="2" class="text-center">
                                            Ação
                                            <button type="button" class="btn btn-success btn-sm" onclick="adicionarLinha3()">+</button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="materiais-table-body">
                                    @foreach ($materiais as $material)
                                        <tr>
                                            @if(is_object($material))
                                                <td>
                                                    <button type="button" class="btn btn-primary form-control"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalProcedimento4"
                                                        data-agenda-id="{{ $guiaSadt->paciente_id }}"
                                                        onclick="setRow4(this, '{{ $guiaSadt->paciente_id }}')">
                                                    <i class="bi bi-list"></i>
                                                </button>
                                                <input type="hidden" name="material_id[]" value="{{ $material->id ?? '' }}">
                                                <td><input style="width: 50px;" class="form-control" name="cd[]" type="text" value="{{ $material->cd ?? '' }}"></td>
                                                <td><input style="width: 120px;" class="form-control" name="created_at[]" type="text" value="{{ $material->created_at ? \Carbon\Carbon::parse($material->created_at)->format('d/m/Y') : '' }}"></td>
                                                <td><input class="form-control" name="hora_inicial[]" type="text" value="{{ $material->created_at ? \Carbon\Carbon::parse($material->created_at)->format('H:i') : '' }}"></td>
                                                <td><input class="form-control" name="hora_final[]" type="text" value="{{ $material->created_at ? \Carbon\Carbon::parse($material->created_at)->format('H:i') : '' }}"></td>
                                                <td><input class="form-control" name="tabela[]" type="text" value="{{ $material->tabela ?? '' }}"></td>
                                                <td><input class="form-control" name="nome_material[]" type="text" value="{{ $material->nome_material ?? '' }}"></td>
                                                <td><input class="form-control" name="codigo[]" type="text" value="{{ $material->codigo ?? '' }}"></td>
                                                <td><input class="form-control quantidade" name="quantidade[]" type="number" value="{{ $material->quantidade ?? '' }}"></td>
                                                <td>
                                                    <select id="unidade_medida" name="unidade_medida[]" class="form-control">
                                                        <option value="">Selecione</option>
                                                        <option value="001" {{ old('unidade_medida', $material->unidade_medida ?? '') == '001' ? 'selected' : '' }}>Unidade</option>
                                                        <option value="002" {{ old('unidade_medida', $material->unidade_medida ?? '') == '002' ? 'selected' : '' }}>Caixa</option>
                                                        <option value="003" {{ old('unidade_medida', $material->unidade_medida ?? '') == '003' ? 'selected' : '' }}>Frasco</option>
                                                        <option value="004" {{ old('unidade_medida', $material->unidade_medida ?? '') == '004' ? 'selected' : '' }}>Ampola</option>
                                                        <option value="005" {{ old('unidade_medida', $material->unidade_medida ?? '') == '005' ? 'selected' : '' }}>Comprimido</option>
                                                        <option value="006" {{ old('unidade_medida', $material->unidade_medida ?? '') == '006' ? 'selected' : '' }}>Gotas</option>
                                                        <option value="007" {{ old('unidade_medida', $material->unidade_medida ?? '') == '007' ? 'selected' : '' }}>Mililitro (ml)</option>
                                                        <option value="008" {{ old('unidade_medida', $material->unidade_medida ?? '') == '008' ? 'selected' : '' }}>Grama (g)</option>
                                                        <option value="036" {{ old('unidade_medida', $material->unidade_medida ?? '') == '036' ? 'selected' : '' }}>Outros</option>
                                                    </select>
                                                </td>
                                                <td><input class="form-control fator" name="fator[]" type="number" value="{{ $material->fator ?? '' }}"></td>
                                                <td><input class="form-control valor" name="valor[]" type="text" value="{{ $material->valor ?? '' }}"></td>
                                                <td><input class="form-control valor_total" name="valor_total[]" type="number" value="{{ $material->valor_total ?? '' }}"></td>
                                                <td><button type="button" class="form-control btn btn-success" onclick="adicionarLinha3()">+</button></td>
                                                <td><button type="button" class="form-control btn btn-danger" onclick="removerLinha3(this)">-</button></td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody id="taxas-table-body">
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
<div class="modal fade" id="modalProcedimento2" tabindex="-1" aria-labelledby="modalProcedimentoLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 50%; margin: 1.75rem auto;">
        <div class="modal-content" style="max-height: calc(100vh - 3.5rem); overflow-y: auto; overflow-x: hidden;">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProcedimentoLabel2">Selecione o Procedimento</h5>
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
                    <tbody id="procTableBody1">
                        <!-- Procedimentos serão carregados aqui -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalProcedimento3" tabindex="-1" aria-labelledby="modalProcedimentoLabel3" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 50%; margin: 1.75rem auto;">
        <div class="modal-content" style="max-height: calc(100vh - 3.5rem); overflow-y: auto; overflow-x: hidden;">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProcedimentoLabel3">Selecione o Procedimento</h5>
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
                            <th>Medicamento</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="procTableBody3">
                        <!-- Procedimentos serão carregados aqui -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalProcedimento4" tabindex="-1" aria-labelledby="modalProcedimentoLabel3" aria-hidden="true" data-data-atendimento="{{ $agenda->data_atendimento ?? '' }}"
     data-hora-atendimento="{{ $agenda->hora_atendimento ?? '' }}">
    <div class="modal-dialog modal-lg" style="max-width: 50%; margin: 1.75rem auto;">
        <div class="modal-content" style="max-height: calc(100vh - 3.5rem); overflow-y: auto; overflow-x: hidden;">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProcedimentoLabel3">Selecione o Procedimento</h5>
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
                            <th>Material</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody id="procTableBody4">
                        <!-- Medicamentos serão carregados aqui -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<script>
function adicionarLinha() {
    var tableBody = document.getElementById('exame-table-body');

    // Criar uma nova linha do zero
    var newRow = document.createElement('tr');
    newRow.style.textAlign = "center";

    newRow.innerHTML = `
        <td>
            <button type="button" class="btn btn-primary form-control"
                    data-bs-toggle="modal"
                    data-bs-target="#modalProcedimento1"
                    data-agenda-id="{{ $guiaSadt->paciente_id }}"
                    onclick="setRow1(this, '{{ $guiaSadt->paciente_id }}')">
                <i class="bi bi-list"></i>
            </button>
        </td>
        <td>
            <input class="form-control" name="agenda_id2[]" type="hidden" value="">
            <input class="form-control" style="text-align: center;" name="tabela[]" type="text" value="22" readonly>
        </td>
        <td><input class="form-control" name="codigo_procedimento_solicitado[]" type="text" readonly></td>
        <td><input class="form-control" name="descricao_procedimento[]" type="text" readonly></td>
        <td><input class="form-control" style="text-align: center;" name="qtd_sol[]" type="number" value="1"></td>
        <td><input class="form-control" style="text-align: center;" name="qtd_aut[]" type="number" ></td>
        <td><button type="button" class="form-control btn btn-success" onclick="adicionarLinha()">+</button></td>
        <td><button type="button" class="form-control btn btn-danger" onclick="removerLinha(this)">-</button></td>
    `;

    // Adicionar a nova linha ao final da tabela
    tableBody.appendChild(newRow);
}



    // Função para remover a linha
    window.removerLinha = function(button) {
        const tabela = $(button).closest('table');
        const totalLinhas = tabela.find('tbody tr').length;

        $(button).closest('tr').remove();
    };

    // Função para definir o contexto da linha (se necessário)
    function setRowContext(button, pacienteId) {
        // Aqui você pode adicionar o código para definir o contexto do paciente ou linha, se necessário
        console.log('Definindo contexto para paciente ID: ' + pacienteId);
    }


    function adicionarLinha1() {
    var tableBody = document.getElementById('procedimento-table-body');

    // Criar uma nova linha vazia
    var newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td>
            <button type="button" class="btn btn-primary form-control"
                    data-bs-toggle="modal"
                    data-bs-target="#modalProcedimento2"
                    data-agenda-id="{{ $guiaSadt->paciente_id }}"
                    onclick="setRow2(this, '{{ $guiaSadt->paciente_id }}')">
                <i class="bi bi-list"></i>
            </button>
        </td>
        <td><input style="width: 119px;" class="form-control" name="data_real[]" type="text" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
        <td><input class="form-control" name="hora_inicio_atendimento[]" type="text" value=""></td>
        <td><input class="form-control" name="hora_fim_atendimento[]" type="text" value=""></td>
        <td><input class="form-control" name="tabela[]" type="text" value="22" readonly></td>
        <td><input class="form-control" name="codigo_procedimento_realizado[]" type="text"></td>
        <td><input class="form-control" name="descricao_procedimento_realizado[]" type="text"></td>
        <td><input class="form-control quantidade_autorizada" name="quantidade_autorizada[]" type="number" value="1" min="1" oninput="calcularValorTotal(this)"></td>
        <td>
            <select class="form-control" name="via[]">
                <option value="">Selecione</option>
                <option value="1">Unidade</option>
                <option value="2">Múltiplo</option>
            </select>
        </td>
        <td>
            <select class="form-control" name="tecnica[]">
                <option value="">Selecione</option>
                <option value="U">Unilateral</option>
                <option value="B">Bilateral</option>
                <option value="M">Múltiplo</option>
                <option value="S">Simples</option>
                <option value="C">Complexo</option>
                <option value="A">Avançado</option>
            </select>
        </td>
        <td><input class="form-control" name="fator_red_acres[]" type="text" placeholder="EX:1,00" oninput="calcularValorTotal(this)"></td>
        <td><input class="form-control valor_unitario" name="valor_unitario[]" type="text" value="" oninput="calcularValorTotal(this)"></td>
        <td><input class="form-control valor_total" name="valor_total[]" type="text" value="" placeholder="Valor Total"></td>
        <td><button type="button" class="btn btn-success" onclick="adicionarLinha1()">+</button></td>
        <td><button type="button" class="btn btn-danger" onclick="removerLinha1(this)">-</button></td>
    `;

    // Adicionar a nova linha ao final da tabela
    tableBody.appendChild(newRow);
}



    // Função para remover a linha
    window.removerLinha1 = function(button) {
        const tabela = $(button).closest('table');
        const totalLinhas = tabela.find('tbody tr').length;

        $(button).closest('tr').remove();
    };

    // Função para calcular o valor total (exemplo)
    function calcularValorTotal(input) {
        var row = input.closest('tr'); // Encontra a linha onde o input está
        var quantidade = row.querySelector('.quantidade_autorizada').value;
        var valorUnitario = row.querySelector('.valor_unitario').value;
        var fator = row.querySelector('#fator_red_acres').value;

        // Calcular o valor total com base nas entradas
        var valorTotal = quantidade * valorUnitario * (fator ? parseFloat(fator) : 1);

        row.querySelector('.valor_total').value = valorTotal.toFixed(2); // Atualiza o valor total
    }

    function adicionarLinha2() {
        var tableBody = document.getElementById('medicamentos-table-body');

        // Criar uma nova linha vazia
        var newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>
                <button type="button" class="btn btn-primary form-control"
                        data-bs-toggle="modal"
                        data-bs-target="#modalProcedimento3"
                        data-agenda-id="{{ $guiaSadt->paciente_id }}"
                        onclick="setRow3(this, '{{ $guiaSadt->paciente_id }}')">
                    <i class="bi bi-list"></i>
                </button>
            </td>
            <td>
                <input style="width: 50px;" class="form-control" name="cd[]" type="text" value="">
                <input style="width: 50px;" class="form-control" name="medicamento_id[]" type="hidden" value="">
            </td>
            <td><input style="width: 119px;" class="form-control" name="created_at[]" type="text" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
            <td><input class="form-control" type="text" name="hora_inicial[]" value=""></td>
            <td><input class="form-control" type="text" name="hora_final[]" value=""></td>
            <td><input class="form-control" type="text" name="tabela[]" value=""></td>
            <td><input class="form-control" name="nome_medicamento[]" type="text" value=""></td>
            <td><input class="form-control" name="codigo[]" type="text" value=""></td>
            <td><input class="form-control quantidade" name="quantidade[]" type="number" value="1" min="1"></td>
            <td>
                <select name="unidade_medida[]" class="form-control">
                    <option value="">Selecione</option>
                    <option value="001">Unidade</option>
                    <option value="002">Caixa</option>
                    <option value="003">Frasco</option>
                    <option value="004">Ampola</option>
                    <option value="005">Comprimido</option>
                    <option value="006">Gotas</option>
                    <option value="007">Mililitro (ml)</option>
                    <option value="008">Grama (g)</option>
                    <option value="036">Outros</option>
                </select>
            </td>
            <td><input class="form-control fator" name="fator[]" type="text" value=""></td>
            <td><input class="form-control valor" name="valor[]" type="text" value=""></td>
            <td><input class="form-control valor_total" name="valor_total[]" type="text" value=""></td>
            <td><button type="button" class="form-control btn btn-success" onclick="adicionarLinha2()">+</button></td>
            <td><button type="button" class="form-control btn btn-danger" onclick="removerLinha2(this)">-</button></td>
        `;

        // Adicionar a nova linha ao final da tabela
        tableBody.appendChild(newRow);
    }

    // Função para remover a linha
    window.removerLinha2 = function(button) {
        const tabela = $(button).closest('table');
        const totalLinhas = tabela.find('tbody tr').length;

        $(button).closest('tr').remove();
    };

    function adicionarLinha3() {
        var tableBody = document.getElementById('materiais-table-body');

        // Criar uma nova linha do zero
        var newRow = document.createElement('tr');

        newRow.innerHTML = `
            <td>
                <button type="button" class="btn btn-primary form-control"
                        data-bs-toggle="modal"
                        data-bs-target="#modalProcedimento4"
                        data-agenda-id="{{ $guiaSadt->paciente_id }}"
                        onclick="setRow4(this, '{{ $guiaSadt->paciente_id }}')">
                    <i class="bi bi-list"></i>
                </button>
                <input type="hidden" name="material_id[]" value="">
            </td>
            <td><input style="width: 50px;" class="form-control" name="cd[]" type="text" value=""></td>
            <td><input style="width: 120px;" class="form-control" name="created_at[]" type="text" value="{{ \Carbon\Carbon::now()->format('d/m/Y') }}"></td>
            <td><input class="form-control" name="hora_inicial[]" type="text" value=""></td>
            <td><input class="form-control" name="hora_final[]" type="text" value=""></td>
            <td><input class="form-control" name="tabela[]" type="text" value=""></td>
            <td><input class="form-control" name="nome_material[]" type="text" value=""></td>
            <td><input class="form-control" name="codigo[]" type="text" value=""></td>
            <td><input class="form-control quantidade" name="quantidade[]" type="number" value="1" min="1"></td>
            <td>
                <select name="unidade_medida[]" class="form-control">
                    <option value="">Selecione</option>
                    <option value="001">Unidade</option>
                    <option value="002">Caixa</option>
                    <option value="003">Frasco</option>
                    <option value="004">Ampola</option>
                    <option value="005">Comprimido</option>
                    <option value="006">Gotas</option>
                    <option value="007">Mililitro (ml)</option>
                    <option value="008">Grama (g)</option>
                    <option value="036">Outros</option>
                </select>
            </td>
            <td><input class="form-control fator" name="fator[]" type="number" value=""></td>
            <td><input class="form-control valor" name="valor[]" type="text" value=""></td>
            <td><input class="form-control valor_total" name="valor_total[]" type="number" value=""></td>
            <td><button type="button" class="form-control btn btn-success" onclick="adicionarLinha3()">+</button></td>
            <td><button type="button" class="form-control btn btn-danger" onclick="removerLinha3(this)">-</button></td>
        `;

        // Adicionar a nova linha ao final da tabela
        tableBody.appendChild(newRow);
    }


    // Função para remover a linha
    window.removerLinha3 = function(button) {
        const tabela = $(button).closest('table');
        const totalLinhas = tabela.find('tbody tr').length;

        $(button).closest('tr').remove();
    };


    function setRow1(button) {
        // Identifica a linha correspondente ao botão clicado
        activeRow = $(button).closest('tr');

        var pacienteId = $(button).data('agenda-id');

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
            console.log("Preenchendo os campos da linha ativa...");

            // Preenchendo os campos corretamente usando os seletores de name[]
            activeRow.find('input[name="codigo_procedimento_solicitado[]"]').val(codigo);
            activeRow.find('input[name="descricao_procedimento[]"]').val(procedimento);

            // Debug para verificar se os dados foram preenchidos corretamente
            console.log("Código:", activeRow.find('input[name="codigo_procedimento_solicitado[]"]').val());
            console.log("Descrição:", activeRow.find('input[name="descricao_procedimento[]"]').val());

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
            alert('Nenhuma linha ativa foi selecionada para preenchimento!');
        }
    }


    $('[id^=procSearch]').on('keyup', function() {
        var inputId = $(this).attr('id'); // Obtém o ID do campo de busca
        var inputValue = $(this).val().toLowerCase().trim(); // Valor da busca em minúsculas e sem espaços extras
        var tableId = inputId.replace('Search', 'Table'); // Mapeia o ID da tabela correspondente
        var rows = $('#' + tableId + ' tbody tr'); // Seleciona todas as linhas da tabela

        rows.each(function() {
            var codigo = $(this).find('td').eq(0).text().toLowerCase().trim(); // Código da linha
            var procedimento = $(this).find('td').eq(1).text().toLowerCase().trim(); // Procedimento da linha

            // Verifica se o código ou procedimento contém o valor digitado
            if (codigo.includes(inputValue) || procedimento.includes(inputValue)) {
                $(this).show(); // Exibe a linha
            } else {
                $(this).hide(); // Esconde a linha
            }
        });
    });

    function setRow2(button) {
        // Identifica a linha correspondente ao botão clicado
        activeRow = $(button).closest('tr');

        var pacienteId = $(button).data('agenda-id');

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
                const tableBody = document.getElementById('procTableBody1');
                tableBody.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(procedimento => {
                        const row = `
                            <tr>
                                <td>${procedimento.codigo}</td>
                                <td>${procedimento.procedimento}</td>
                                <td>
                                    <button class="btn btn-primary" type="button"
                                    onclick="selectProcedimento2('${procedimento.id}', '${procedimento.codigo}', '${procedimento.procedimento}', '${procedimento.valor_proc}')">Selecionar</button>
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

    function selectProcedimento2(id, codigo, procedimento, valor_proc) {
    if (activeRow) {
        console.log("Preenchendo os campos da linha ativa...");

        // Capturar a data e hora do modal ou usar a data/hora atual como fallback
        var data_atendimento = $('#modalProcedimento2').attr('data-data-atendimento') || new Date().toISOString().split('T')[0];
        var hora_atendimento = $('#modalProcedimento2').attr('data-hora-atendimento') || new Date().toTimeString().slice(0, 5);

        // Preenchendo os campos corretamente usando os seletores de name[]
        activeRow.find('input[name="codigo_procedimento_realizado[]"]').val(codigo);
        activeRow.find('input[name="descricao_procedimento_realizado[]"]').val(procedimento);
        activeRow.find('input[name="valor_unitario[]"]').val(valor_proc);

        // Preenchendo os novos campos com data e hora
        activeRow.find('input[name="data_real[]"]').val(new Date().toLocaleDateString('pt-BR')); // Data atual formatada
        activeRow.find('input[name="hora_inicio_atendimento[]"]').val(hora_atendimento + ':00'); // Hora inicial com segundos
        activeRow.find('input[name="hora_fim_atendimento[]"]').val(hora_atendimento + ':00'); // Hora final com segundos

        // Debug para verificar se os dados foram preenchidos corretamente
        console.log("Código:", activeRow.find('input[name="codigo_procedimento_realizado[]"]').val());
        console.log("Descrição:", activeRow.find('input[name="descricao_procedimento_realizado[]"]').val());
        console.log("Valor Unitário:", activeRow.find('input[name="valor_unitario[]"]').val());
        console.log("Data Atendimento:", activeRow.find('input[name="data_real[]"]').val());
        console.log("Hora Inicial:", activeRow.find('input[name="hora_inicio_atendimento[]"]').val());
        console.log("Hora Final:", activeRow.find('input[name="hora_fim_atendimento[]"]').val());

        // Fecha o modal
        const modalProcedimento2 = bootstrap.Modal.getInstance(document.getElementById('modalProcedimento2'));
        modalProcedimento2.hide();

        // Opcional: Reabre outro modal, se necessário
        setTimeout(() => {
            const modalSADT = new bootstrap.Modal(document.getElementById('modalSADT'));
            modalSADT.show();
        }, 500);
    } else {
        console.error('Nenhuma linha ativa encontrada para preencher os campos.');
        alert('Nenhuma linha ativa foi selecionada para preenchimento!');
    }
}



    function setRow3(button) {
        // Identifica a linha correspondente ao botão clicado
        activeRow = $(button).closest('tr');

        var pacienteId = $(button).data('agenda-id');

        // Definir o valor no modal, por exemplo, em um campo hidden ou exibindo na interface
        $('#modalProcedimento1').find('#hiddenAgendaId').val(pacienteId); // Para campos hidden
        $('#modalProcedimento1').find('.agenda-display').text(pacienteId);

        if (!pacienteId) {
            alert('Paciente ID não encontrado!');
            return;
        }

        fetch(`/api/get-medicamentos/${pacienteId}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('procTableBody3');
                tableBody.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(medicamento => {
                        const row = `
                            <tr>
                                <td>${medicamento.codigo}</td>
                                <td>${medicamento.medicamento}</td>
                                <td>
                                    <button class="btn btn-primary" type="button"
                                    onclick="selectProcedimento3('${medicamento.id}', '${medicamento.codigo}', '${medicamento.medicamento}','${medicamento.preco}')">Selecionar</button>
                                </td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML('beforeend', row);
                    });
                } else {
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="3" class="text-center">Nenhum medicamento disponível.</td>
                        </tr>
                    `;
                }
            })
            .catch(error => {
                console.error('Erro ao buscar medicamento:', error);
                alert('Erro ao buscar medicamento!');
            });
    }

    function selectProcedimento3(id, codigo, medicamento, preco) {
    if (activeRow) {
        console.log("Preenchendo os campos da linha ativa...");

        // Preenche os campos da linha ativa pelos IDs
        activeRow.find('input[name="medicamento_id[]"]').val(id);
        activeRow.find('input[name="codigo[]"]').val(codigo);
        activeRow.find('input[name="nome_medicamento[]"]').val(medicamento);
        activeRow.find('input[name="valor[]"]').val(preco);

        // Define um valor padrão para quantidade (1) caso esteja vazio
        let quantidadeInput = activeRow.find('input[name="quantidade[]"]');
        if (!quantidadeInput.val()) {
            quantidadeInput.val(1);
        }

        // Calcula o valor total inicial (quantidade * preço)
        let valorTotal = parseFloat(preco) * parseInt(quantidadeInput.val());
        activeRow.find('input[name="valor_total[]"]').val(valorTotal.toFixed(2));

        // Evento para recalcular o valor total quando a quantidade for alterada
        quantidadeInput.on('input', function () {
            let quantidade = parseInt($(this).val()) || 0;
            let novoValorTotal = quantidade * parseFloat(preco);
            activeRow.find('input[name="valor_total[]"]').val(novoValorTotal.toFixed(2));
        });

        // Calcula o valor total inicial (quantidade * preço)
        activeRow.find('#valor_total').val(parseFloat(preco).toFixed(2));

        // Preenche novos campos adicionais
        var data_atendimento = $('#modalProcedimento3').attr('data-data-atendimento') || new Date().toISOString().split('T')[0];
        var hora_atendimento = $('#modalProcedimento3').attr('data-hora-atendimento') || new Date().toTimeString().slice(0, 5);

        activeRow.find('input[name="created_at[]"]').val('{{ \Carbon\Carbon::now()->format('d/m/Y') }}'); // Data atual formatada
        activeRow.find('input[name="hora_inicial[]"]').val(hora_atendimento + ':00'); // Hora inicial com segundos
        activeRow.find('input[name="hora_final[]"]').val(hora_atendimento + ':00'); // Hora final com segundos (pode ser ajustada conforme necessário)
        activeRow.find('input[name="tabela[]').val('20'); // Valor fixo para tabela
        activeRow.find('input[name="cd[]').val('02'); // Código fixo 03

        // Debug para garantir que os valores estão corretos
        console.log("Linha preenchida:");
        console.log("Código:", activeRow.find('#codigo').val());
        console.log("Nome:", activeRow.find('#nome_medicamento').val());
        console.log("Valor:", activeRow.find('#valor').val());
        console.log("Quantidade:", activeRow.find('#quantidade').val());
        console.log("Total:", activeRow.find('#valor_total').val());
        console.log("Data:", activeRow.find('#created_at').val());
        console.log("Hora Inicial:", activeRow.find('#hora_inicial').val());
        console.log("Hora Final:", activeRow.find('#hora_final').val());
        console.log("Tabela:", activeRow.find('#tabela').val());

        // Fecha o modal
        const modalProcedimento3 = bootstrap.Modal.getInstance(document.getElementById('modalProcedimento3'));
        modalProcedimento3.hide();

        // Opcional: Reabre outro modal, se necessário
        setTimeout(() => {
            const modalSADT = new bootstrap.Modal(document.getElementById('modalSADT'));
            modalSADT.show();
        }, 500);
    } else {
        console.error('Nenhuma linha ativa encontrada para preencher os campos.');
    }
}

    function setRow4(button) {
    activeRow = $(button).closest('tr');

    var pacienteId = $(button).data('agenda-id');

    console.log("Paciente ID encontrado:", pacienteId); // <-- TESTE AQUI!

    $('#modalProcedimento4').find('#hiddenAgendaId').val(pacienteId);
    $('#modalProcedimento4').find('.agenda-display').text(pacienteId);

    if (!pacienteId || pacienteId === "undefined" || pacienteId === "null") {
        alert('Paciente ID não encontrado!');
        return;
    }

    fetch(`/api/get-materiais/${pacienteId}`)
    .then(response => response.json())
    .then(data => {
        console.log("Dados recebidos:", data); // <-- Veja a estrutura dos dados no Console do Navegador

        const tableBody = document.getElementById('procTableBody4');
        tableBody.innerHTML = '';

        if (data.length > 0) {
            data.forEach(material => {
                console.log("Material recebido:", material); // <-- Depuração

                const row = `
                    <tr>
                        <td>${material.codigo}</td>
                        <td>${material.material ?? 'Nome não encontrado'}</td>
                        <td>
                            <button class="btn btn-primary" type="button"
                            onclick="selectProcedimento4('${material.id}', '${material.codigo}', '${material.material ?? ''}', '${material.preco}')">Selecionar</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        } else {
            tableBody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center">Nenhum material disponível.</td>
                </tr>
            `;
        }
    })
    .catch(error => {
        console.error('Erro ao buscar materiais:', error);
        alert('Erro ao buscar materiais!');
    });

}


function selectProcedimento4(id, codigo, material, preco) {
    if (activeRow) {
        console.log("Preenchendo os campos da linha ativa...");

        // Pegamos a data e horário da agenda diretamente do modal (caso necessário)
        var data_atendimento = $('#modalProcedimento4').attr('data-data-atendimento') || new Date().toISOString().split('T')[0]; // Pega a data da agenda ou a data atual
        var hora_atendimento = $('#modalProcedimento4').attr('data-hora-atendimento') || new Date().toTimeString().slice(0, 5); // Pega a hora da agenda ou a hora atual

        // Preenche os campos dentro da linha ativa
        activeRow.find('input[name="codigo[]"]').val(codigo);
        activeRow.find('input[name="nome_material[]"]').val(material);
        activeRow.find('input[name="valor[]"]').val(preco);
        activeRow.find('input[name="material_id[]"]').val(id);

        // Define a quantidade como 1 por padrão
        activeRow.find('input[name="quantidade[]"]').val(1);

        // Calcula o valor total com base na quantidade (inicialmente 1)
        activeRow.find('input[name="valor_total[]"]').val(parseFloat(preco).toFixed(2));

        // Preenchendo os novos campos
        activeRow.find('input[name="created_at[]"]').val('{{ \Carbon\Carbon::now()->format('d/m/Y') }}'); // Data atual formatada
        activeRow.find('input[name="hora_inicial[]"]').val(hora_atendimento); // Hora inicial
        activeRow.find('input[name="hora_final[]"]').val(hora_atendimento); // Hora final (pode ser ajustada conforme necessário)
        activeRow.find('input[name="tabela[]"]').val('19'); // Tabela fixa 19
        activeRow.find('input[name="cd[]"]').val('03'); // Código fixo 03

        // Evento para recalcular o valor total quando a quantidade mudar
        activeRow.find('input[name="quantidade[]"]').on('input', function () {
            var quantidade = parseInt($(this).val()) || 0;
            var novoValorTotal = quantidade * parseFloat(preco);
            activeRow.find('input[name="valor_total[]"]').val(novoValorTotal.toFixed(2));
        });

        // Debug para garantir que os valores estão sendo atribuídos
        console.log("Linha preenchida:");
        console.log("Código:", activeRow.find('input[name="codigo[]"]').val());
        console.log("Nome:", activeRow.find('input[name="nome_material[]"]').val());
        console.log("Valor:", activeRow.find('input[name="valor[]"]').val());
        console.log("Total:", activeRow.find('input[name="valor_total[]"]').val());
        console.log("Data:", activeRow.find('input[name="created_at[]"]').val());
        console.log("Hora Inicial:", activeRow.find('input[name="hora_inicial[]"]').val());
        console.log("Hora Final:", activeRow.find('input[name="hora_final[]"]').val());
        console.log("Tabela:", activeRow.find('input[name="tabela[]"]').val());

        // Fecha o modal
        const modalProcedimento4 = bootstrap.Modal.getInstance(document.getElementById('modalProcedimento4'));
        modalProcedimento4.hide();
    } else {
        console.error('Nenhuma linha ativa encontrada para preencher os campos.');
    }
}
</script>

@endsection
