<div class="row">
    <div class="mb-3 col-md-3">
        <label class="form-label"><strong>Peso (Kg):</strong></label>
        <input class="form-control" id="peso" name="peso" type="text" value="{{ $historico->an_peso }}" oninput="calcularIMC()">
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label"><strong>Altura (m):</strong></label>
        <input class="form-control" id="altura" name="altura" type="text" value="{{ $historico->an_altura }}" oninput="calcularIMC()">
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label"><strong>IMC:</strong></label>
        <input class="form-control" id="imc" name="imc" type="text" value="{{ $historico->imc }}" readonly>
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label"><strong>Classificação:</strong></label>
        <input class="form-control" id="classificacao" name="classificacao" type="text" value="{{ $historico->classificacao }}" readonly>
    </div>
</div>  
<div class="row">
    <div class="mb-3 col-md-6">
        <label class="form-label"><strong>PA mmHg:</strong></label>
        <input class="form-control" id="pa" name="pa" type="text" value="{{ $historico->an_pa }}" readonly>
    </div>
    <div class="mb-3 col-md-6">
        <label class="form-label"><strong>Temp(ºC):</strong></label>
        <input class="form-control" id="temp" name="temp" type="text" value="{{ $historico->an_temp }}" readonly>
    </div>
</div>
<div class="row">
    <div class="mb-3 col-md-2">
        <label class="form-label"><strong>Gestante:</strong></label>
        <input class="form-control" id="gestante" name="gestante" type="text" value="{{ $historico->an_gestante }}" readonly>
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label"><strong>Dextro (mg/dL):</strong></label>
        <input class="form-control" id="dextro" name="dextro" type="text" value="{{ $historico->an_dextro }}" readonly>
    </div>
    <div class="mb-3 col-md-3">
        <label class="form-label"><strong>SpO2:</strong></label>
        <input class="form-control" id="spo2" name="spo2" type="text" value="{{ $historico->an_spo2 }}" readonly>
    </div>
    <div class="mb-3 col-md-2">
        <label class="form-label"><strong>F.C.:</strong></label>
        <input class="form-control" id="fc" name="fc" type="text" value="{{ $historico->an_fc }}" readonly>
    </div>
    <div class="mb-3 col-md-2">
        <label class="form-label"><strong>F.R.:</strong></label>
        <input class="form-control" id="fr" name="fr" type="text" value="{{ $historico->an_fr }}" readonly>
    </div>
</div>
<hr>
<div class="row" style="text-align: center">
    <div class="mb-3 col-md-12">
        <label class="form-label"><strong>Acolhimento</strong></label>
        <input class="form-control" id="acolhimento" name="acolhimento" type="text" value="{{ $historico->an_acolhimento }}" readonly>
    </div>
</div>
<div class="row" style="text-align: center">
    <div class="mb-3 col-md-12">
        <label class="form-label"><strong>Queixas Principais do Acolhimento</strong></label>
    </div>
</div>
<div class="row">
    <div class="mb-3 col-md-3">
        <input class="form-control" id="acolhimento1" name="acolhimento1" type="text" value="{{ $historico->an_acolhimento1 }}" readonly>
    </div>
    <div class="mb-3 col-md-3">
        <input class="form-control" id="acolhimento2" name="acolhimento2" type="text" value="{{ $historico->an_acolhimento2 }}" readonly>
    </div>
    <div class="mb-3 col-md-3">
        <input class="form-control" id="acolhimento3" name="acolhimento3" type="text" value="{{ $historico->an_acolhimento3 }}" readonly>
    </div>
    <div class="mb-3 col-md-3">
        <input class="form-control" id="acolhimento4" name="acolhimento4" type="text" value="{{ $historico->an_acolhimento4 }}" readonly>
    </div>
</div>
<div class="row" style="text-align: center">
    <div class="mb-3 col-md-12">
        <label class="form-label"><strong>Alergias</strong></label>
    </div>
</div>
<div class="row">
    <div class="mb-3 col-md-4">
        <input class="form-control" id="alergia1" name="alergia1" type="text" value="{{ $historico->an_alergia1 }}" readonly>
    </div>
    <div class="mb-3 col-md-4">
        <input class="form-control" id="alergia2" name="alergia2" type="text" value="{{ $historico->an_alergia2 }}" readonly>
    </div>
    <div class="mb-3 col-md-4">
        <input class="form-control" id="alergia3" name="alergia3" type="text" value="{{ $historico->an_alergia3 }}" readonly>
    </div>
</div>
<div class="row">
    <div class="mb-3">
        <label class="form-label"><strong>Anamnese / Exame Fisico:</strong></label>
        <textarea class="form-control" rows="5" id="anamnese" name="anamnese" readonly>{{ $historico->an_anamnese }}</textarea>
    </div>
</div>