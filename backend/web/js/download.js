$( document ).ready(function() {
    var urls = [];
    $( ".photo" ).each(function( index ) {
        urls.push($(this).attr('src'));
    });

    $('#download').on('click', function (e){
        e.preventDefault();
        e.stopPropagation();
        downloadImages(urls, collectionName);
    })

});

function downloadImages(urls, collectionName) {

    var zip = new JSZip();
    var count = 0;
    var count2 = 0;
    var zipFilename = collectionName;
    var nameFromURL = [];

    var the_arr = "";
    for (var i = 0; i< urls.length; i++){
        the_arr = urls[i].split('/');
        nameFromURL[i] = the_arr.pop();

    }

    urls.forEach(function(url){
        var filename = nameFromURL[count2];
        count2++;
        // loading a file and add it in a zip file
        JSZipUtils.getBinaryContent(url, function (err, data) {
            if(err) {
                throw err; // or handle the error
            }
            zip.file(filename, data, {binary:true});
            count++;
            if (count === urls.length) {
                zip.generateAsync({type:'blob'}).then(function(content) {
                    saveAs(content, zipFilename);
                });
            }
        });
    });
}