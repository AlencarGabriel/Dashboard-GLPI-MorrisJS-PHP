var Days = [];
var ChamadosTecnicos = [];

// INICIO do trecho de ajuste dos gráficos, para montar os labels
(function() {

    var $, MyMorris;

    MyMorris = window.MyMorris = {};
    $ = jQuery;

    MyMorris = Object.create(Morris);

    MyMorris.Bar.prototype.defaults["labelTop"] = false;

    MyMorris.Bar.prototype.drawLabelTop = function(xPos, yPos, text) {
        var label;
        return label = this.raphael.text(xPos, yPos, text).attr('font-size', this.options.gridTextSize).attr('font-family', this.options.gridTextFamily).attr('font-weight', this.options.gridTextWeight).attr('fill', this.options.gridTextColor);
    };

    MyMorris.Bar.prototype.drawSeries = function() {
        var barWidth, bottom, groupWidth, idx, lastTop, left, leftPadding, numBars, row, sidx, size, spaceLeft, top, ypos, zeroPos;
        groupWidth = this.width / this.options.data.length;
        numBars = this.options.stacked ? 1 : this.options.ykeys.length;
        barWidth = (groupWidth * this.options.barSizeRatio - this.options.barGap * (numBars - 1)) / numBars;
        if (this.options.barSize) {
            barWidth = Math.min(barWidth, this.options.barSize);
        }
        spaceLeft = groupWidth - barWidth * numBars - this.options.barGap * (numBars - 1);
        leftPadding = spaceLeft / 2;
        zeroPos = this.ymin <= 0 && this.ymax >= 0 ? this.transY(0) : null;
        return this.bars = (function() {
            var _i, _len, _ref, _results;
            _ref = this.data;
            _results = [];
            for (idx = _i = 0, _len = _ref.length; _i < _len; idx = ++_i) {
                row = _ref[idx];
                lastTop = 0;
                _results.push((function() {
                    var _j, _len1, _ref1, _results1;
                    _ref1 = row._y;
                    _results1 = [];
                    for (sidx = _j = 0, _len1 = _ref1.length; _j < _len1; sidx = ++_j) {
                        ypos = _ref1[sidx];
                        if (ypos !== null) {
                            if (zeroPos) {
                                top = Math.min(ypos, zeroPos);
                                bottom = Math.max(ypos, zeroPos);
                            } else {
                                top = ypos;
                                bottom = this.bottom;
                            }
                            left = this.left + idx * groupWidth + leftPadding;
                            if (!this.options.stacked) {
                                left += sidx * (barWidth + this.options.barGap);
                            }
                            size = bottom - top;
                            if (this.options.verticalGridCondition && this.options.verticalGridCondition(row.x)) {
                                this.drawBar(this.left + idx * groupWidth, this.top, groupWidth, Math.abs(this.top - this.bottom), this.options.verticalGridColor, this.options.verticalGridOpacity, this.options.barRadius, row.y[sidx]);
                            }
                            if (this.options.stacked) {
                                top -= lastTop;
                            }
                            this.drawBar(left, top, barWidth, size, this.colorFor(row, sidx, 'bar'), this.options.barOpacity, this.options.barRadius);
                            _results1.push(lastTop += size);

                            if (this.options.labelTop && !this.options.stacked) {
                                label = this.drawLabelTop((left + (barWidth / 2)), top - 10, row.y[sidx]);
                                textBox = label.getBBox();
                                _results.push(textBox);
                            }
                        } else {
                            _results1.push(null);
                        }
                    }
                    return _results1;
                }).call(this));
            }
            return _results;
        }).call(this);
    };
}).call(this);
// FIM do trecho de ajuste dos gráficos, para montar os labels

$(document).ready(function(){

    // Função para trazer os dados de chamados
    $.getJSON( "scripts/php/api/getChamados.php")
    .done(function( data ) {
        // chamados
        console.log( data["chamados"] ) ;

        //Carrega o JSON com os dados
        var chamados = data["chamados"];

        // cria um array com os dias de vencimento
        Days = [chamados["Venc_umdia"], 
        chamados["Venc_doisdia"],
        chamados["Venc_tresdia"],
        chamados["Venc_quatrodia"],
        chamados["Venc_cincodia"],
        chamados["Venc_seisdia"],
        chamados["Venc_setedia"],
        chamados["Venc_oitodia"],
        chamados["Venc_novedia"],
        chamados["Venc_dezdia"]];           

        // Preeenche os boxes de quantidade
       /* $("#qtd_n_solucionado").text(chamados["N_Solucionados"]);
        $("#qtd_novos").text(chamados["Novos"]);
        $("#qtd_outros").text(chamados["Outros"]);
        $("#qtd_vencidos").text(chamados["Vencidos"]);
        $("#qtd_n_atribuidos").text(chamados["N_Atribuidos"]);  
        // $("#title").text("Painel GLPI - " + chamados["Dt_hoje"]);  */

        // // Monta o gráfico de chamados a vencer
        // Morris.Bar({
        //     element: 'ChartTicketsVencimento',
        //     data: [
        //     {y: '1 dia',   a: Days[0]},
        //     {y: '2 dias',  a: Days[1]},
        //     {y: '3 dias',  a: Days[2]},
        //     {y: '4 dias',  a: Days[3]},
        //     {y: '5 dias',  a: Days[4]},
        //     {y: '6 dias',  a: Days[5]},
        //     {y: '7 dias',  a: Days[6]},
        //     {y: '8 dias',  a: Days[7]},
        //     {y: '9 dias',  a: Days[8]},
        //     {y: '10 dias', a: Days[9]}
        //     ],
        //     xkey: 'y',
        //     ykeys: ['a'],
        //     labels: ['Dias a vencer', 'Chamados abertos'],
        //     xLabelAngle: 0,
        //     labelTop: true,
        //     gridTextSize:20,
        //     gridTextColor:"#000",
        //     gridTextWeight:"bold"
        // });
    })
    .fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
  });

    // Função para trazer os dados de chamados por tecnico
    $.getJSON( "scripts/php/api/getChamadosTecnicos.php")
    .done(function( data ) {
        // chamados
        console.log( data["chamados"] ) ;

        //Carrega o JSON com os dados
        var chamados = data["chamados"];      

        // Monta o gráfico de chamados a vencer
        // Morris.Bar({
        //     element: 'ChartTicketsNSolucionadosTecnico',
        //     data: chamados,
        //     xkey: 'firstname',
        //     ykeys: ['total'],
        //     labels: ['Técnico', 'Chamados abertos'],
        //     xLabelAngle: 0,
        //     labelTop: true,
        //     gridTextSize:20,
        //     gridTextColor:"#000",
        //     gridTextWeight:"bold"
        // });
    })
    .fail(function( jqXHR, textStatus ) {
      alert( "Request failed: " + textStatus );
  });



})

