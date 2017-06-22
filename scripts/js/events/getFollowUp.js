function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds){
            break;
        }   
    }
}

function getFormattedDate(datetime){
    var d = new Date(datetime);

    d = d.getFullYear() + "-" + ('0' + (d.getMonth() + 1)).slice(-2) + "-" + ('0' + d.getDate()).slice(-2);

    return d;
}

function getFormattedTime(datetime){
    var d = new Date(datetime);

    d = ('0' + d.getHours()).slice(-2) + ":" + ('0' + d.getMinutes()).slice(-2) + ":" + ('0' + d.getSeconds()).slice(-2);

    return d;
}

function getContentFollow(timestamp)
{
    var 
    queryString = {'timestamp' : timestamp};  

    $.get('scripts/php/api/getFollowUp.php', queryString, function(data)
    {
        var responseJSON = JSON.parse(data).followups;
        var resonseTimeStamp = JSON.parse(data).timestamp;

        // console.log(responseJSON);
        var obj = responseJSON;

        for (var k in responseJSON)
        {
            var letter = obj[k].realname.substr(0,1);

            if (obj[k].is_tecnico == false && obj[k].is_ator == true){
                var followup = '<li class="left clearfix" id="'+ obj[k].UUID +'"> ' + 
                                '<span class="chat-img pull-left"> ' +
                                    '<p class="'+ letter.toLowerCase() +' p_left" data-letters="'+ letter +'"></p> ' +
                                    //'<img src="http://bootstrap-apex.com/s4atbv3/images/SergeiMartensAvatar.png" alt="Sergei Martens" class="img-circle"> ' +
                                '</span> ' +
                                '<div class="chat-body clearfix"> ' +
                                    '<div class="header"> ' +
                                        '<strong class="primary-font">' + obj[k].realname + ' - <a target="_blank" href="http://chamados.brametal.com.br/front/ticket.form.php?id=' + obj[k].ticket + '">' + obj[k].ticket + ' | ' + obj[k].name + '</a></strong>  ' +
                                        '<small class="pull-right text-muted"> ' +
                                            '<i class="fa fa-clock-o fa-fw"></i> ' + getFormattedTime(obj[k].date) + ' ' +
                                        '</small> ' +
                                    '</div> ' +
                                    '<p> ' +
                                        obj[k].content + ' ' +
                                    '</p> ' +
                                '</div> ' +
                               '</li> ';
            }else{
                var followup = '<li class="right clearfix" id="'+ obj[k].UUID +'"> ' + 
                                '<span class="chat-img pull-right"> ' +
                                    '<p class="'+ letter.toLowerCase() +' p_right" data-letters="'+ letter +'"></p> ' +
                                    //'<img src="http://bootstrap-apex.com/s4atbv3/images/SergeiMartensAvatar.png" alt="Sergei Martens" class="img-circle"> ' +
                                '</span> ' +
                                '<div class="chat-body clearfix"> ' +
                                    '<div class="header"> ' +
                                        '<small class=" text-muted"> ' +
                                            '<i class="fa fa-clock-o fa-fw"></i> ' + getFormattedTime(obj[k].date) + ' ' +
                                        '</small> ' +
                                        '<strong class="pull-right primary-font">' + obj[k].realname + ' - <a target="_blank" href="http://chamados.brametal.com.br/front/ticket.form.php?id=' + obj[k].ticket + '">' + obj[k].ticket + ' | ' + obj[k].name + '</a></strong>  ' +
                                    '</div> ' +
                                    '<p> ' +
                                        obj[k].content + ' ' +
                                    '</p> ' +
                                '</div> ' +
                               '</li> ';
            }


            $('#chat').prepend(followup);
            $('#' + obj[k].UUID).hide().show('slow');
        } 

        // sleep(1000);
        // reconecta ao receber uma resposta do servidor
        getContentFollow(resonseTimeStamp);
    });
}

$(document).ready(function()
{
    // sleep(1000);
    getContentFollow();
});
