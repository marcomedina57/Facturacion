class Uploadpicture
{
    constructor()
    {

    }

    archivo(evt, id){
        let files = evt.target.files;
        var f = files[0];
        if(f.type.match('image.*')){
            let reader = new FileReader();
            reader.onload = ((theFile) => {
                console.log(theFile);
                return (e) => {
                    console.log(e);
                    
                    //Insertamos la imagen
                    document.getElementById(id).innerHTML = 
                    ['<img class = "responsive-img" src = "', e.target.result,
                '"title"', escape(theFile.name), '"/>'].join(''); 
                };

            })(f);
            reader.readAsDataURL(f);
        }
    }
}