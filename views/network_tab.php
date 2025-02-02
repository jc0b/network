<div id="network-tab"></div>
<h2 data-i18n="network.network"></h2>

<div id="network-msg" data-i18n="listing.loading" class="col-lg-12 text-center"></div>

<script>
$(document).on('appReady', function(){
    $.getJSON(appUrl + '/module/network/get_tab_data/' + serialNumber, function(data){
        if( ! data ){
            // Change loading message to no data
            $('#network-msg').text(i18n.t('no_data'));
            
        } else {
            
            // Hide loading/no data message
            $('#network-msg').text('');
            
            // Update the tab badge count
            $('#network-cnt').text(data.length);
            var skipThese = ['service'];
            $.each(data, function(i,d){

                // Generate rows from data
                var rows = ''
                for (var prop in d){
                    // Skip skipThese
                    if(skipThese.indexOf(prop) == -1){
                        if (d[prop] == '' || d[prop] == null || d[prop] == "none" || prop == ''){
                           // Do nothing for empty values to blank them
                        } else if(prop == 'ipv6prefixlen' && d['ipv6ip'] == 'none'){
                           // Do nothing for IPv6 prefix length when ipv6ip is none
                        } else if(prop == 'status' && d[prop] == 1){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td><span class="label label-success">'+i18n.t('connected')+'</span></td></tr>';
                        } else if(prop == 'status' && d[prop] == 0){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td><span class="label label-danger">'+i18n.t('disconnected')+'</span></td></tr>';
                        } else if(d[prop] == "manual"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+i18n.t('network.manual')+'</td></tr>';
                        } else if(d[prop] == "Automatic"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+i18n.t('network.automatic')+'</td></tr>';
                        } else if(d[prop] == "autoselect"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+i18n.t('network.autoselect')+'</td></tr>';
                        } else if(d[prop] == "autoselect (half-duplex)"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+i18n.t('network.autoselecthalf')+'</td></tr>';
                        } else if(d[prop] == "autoselect (full-duplex)"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+i18n.t('network.autoselectfull')+'</td></tr>';
                        } else if(d[prop] == "not set"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+i18n.t('network.notset')+'</td></tr>';
                        } else if(d[prop] == "dhcp"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>DHCP</td></tr>';
                        } else if(d[prop] == "bootp"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>BOOTP</td></tr>';
                        } else if(prop == "wireless_card_type" && d[prop] == "spairport_wireless_card_type_wifi"){
                           // Apple Silicon Macs report this differently
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>Wi-Fi</td></tr>';
                            
                        // Boolean Values
                        } else if((prop == 'overrideprimary' || prop == 'ipv6coverrideprimary' || prop == 'airdrop_supported' || prop == 'wow_supported')&& d[prop] == "1"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+i18n.t('yes')+'</td></tr>';
                        } else if((prop == 'overrideprimary' || prop == 'ipv6coverrideprimary' || prop == 'airdrop_supported' || prop == 'wow_supported')&& d[prop] == "0"){
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+i18n.t('no')+'</td></tr>';
                            
                        } else {
                           rows = rows + '<tr><th>'+i18n.t('network.'+prop)+'</th><td>'+d[prop]+'</td></tr>';
                        }
                    }
                }

                // Generate table
                if (d.service.indexOf("Wi-Fi") !=-1 || d.service.indexOf("AirPort") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                        .append($('<a href="#tab_wifi-tab">')
                            .append($('<i>')
                                .addClass('fa fa-wifi'))
                            .append(' '+d.service)))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("Ethernet") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-indent fa-rotate-270'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("iPhone") !=-1 || d.service.indexOf("phone") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-mobile'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("iPad") !=-1 || d.service.indexOf("ablet") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-tablet'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("utun") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-train'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("Serial") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-ellipsis-h'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("vmnet") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-clone'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("bond") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-pause'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("Bluetooth") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-bluetooth-b'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("odem") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-tty'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("Thunderbolt") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-bolt'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("USB") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-usb'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("FireWire") !=-1){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-fire-extinguisher'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else if (d.service.indexOf("VPN") !=-1 || ("vpnservername" in d && d.vpnservername !== null)){
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-building-o'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                } else {
                    $('#network-tab')
                        .append($('<h4>')
                            .append($('<i>')
                                .addClass('fa fa-globe'))
                            .append(' '+d.service))
                        .append($('<div style="max-width:550px;">')
                            .append($('<table>')
                                .addClass('table table-striped table-condensed')
                                .append($('<tbody>')
                                    .append(rows))))
                }
            })
        }    
    });
});
</script>
