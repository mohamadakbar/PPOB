$('#tListCampaign tbody').on( 'click', '.detailCampaign', function () {
    var data = table.row( $(this).parents('tr') ).data();
    //alert(JSON.stringify(data));
    location.href='detailCampaign/'+data.id+'';
});

$('#tListProfile').DataTable();

$('#tListWording').DataTable();

