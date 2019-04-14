function getPhotos(albumbId) {
    $.ajax({
        type: 'GET',
        url: 'Data_Controller.php',
        data: {
            'albumbId': albumbId
        },
        dataType: 'json',
        success: function (data) {
            
            addElements(data);
            popup();
            slide(1);
        },
        error: function (data) {
            
        }

    });
}


function addElements(data) {
    var slideshow_container = document.getElementById("slideshow-container");

    data.photos.forEach(function (src) {
        let slide = document.createElement("div");
        slide.className = "slides";

        let imageDiv = document.createElement("div");

        let img = document.createElement("img");
        img.setAttribute("src", src);
        img.setAttribute("width", "800");
        img.setAttribute("height", "500");
        img.className = "slider-image";
        imageDiv.appendChild(img);
        slide.appendChild(imageDiv);
        slideshow_container.appendChild(slide);
    });
}

// function autoSlide()
// {
//     var x = document.getElementsByClassName("slides");
//     for(var i = 0;i<x.length;i++)
//     {
//         x[i].style.display = "none";
//     }

//     if(slideIndex > x.length-1)
//     {
//         slideIndex = 0;
//     }

//     x[slideIndex].style.display = "block";
//     slideIndex++;
//     setTimeout(autoSlide,5000);
// }


var index = 1;

function plusIndex(n) {
    index = index + n;
    slide(index);
}

function slide(n) {
    var i;
    var x = document.getElementsByClassName("slides");

    if (n > x.length) {
        index = 1;
    }

    if (n < 1) {
        index = x.length;
    }

    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
    }

    x[index - 1].style.display = "block";

}

function popup() {
    var modal = document.getElementById('myModal');

    var span = document.getElementById("close");

    modal.style.display = "block";

    span.onclick = function () {
        modal.style.display = "none";
        removeElements();
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
            removeElements();
        }
    }
}

function removeElements() {
    var slideshow_container = document.getElementById("slideshow-container");

    while (slideshow_container.firstChild) {
        slideshow_container.removeChild(slideshow_container.firstChild);
    }
}

function removeAlbums() {
    let album = document.getElementById("albums");

    while (album.firstChild) {
        album.removeChild(album.firstChild);
    }
}

function get_albums() {
    removeAlbums();
    add_loader();

    $.ajax({
        type: 'GET',
        url: 'Data_Controller.php',
        data: {
            'albums': 'albums'
        },
        dataType: 'json',
        success: function (data) {

            remove_loader();
            if (data != null) {
                load_albums(data);
                getNextPhotos();
            } else {
                showMessageForAlbum();
            }

        },
        error: function (data) {
            
        }

    });
}

function getNextPhotos() {
    $.ajax({
        type: 'GET',
        url: 'Data_Controller.php',
        data: {
            'nextPhotos': 'nextPhotos'
        },
        dataType: 'json',
        success: function (data) {},
        error: function (data) {
            
        }

    });
}

window.onload = get_albums();


function add_loader() {
    let loader = document.getElementById("loader");
    loader.style.display = "block";
}


function showMessageForAlbum() {
    let message_container = document.getElementById("message-container");
    message_container.style.display = "block";
}

function remove_loader() {

    let loader = document.getElementById("loader");
    loader.style.display = "none";
}

function load_albums(data) {
    let album = document.getElementById("albums");

    for (var k in data) {
        if (data.hasOwnProperty(k)) {

            let col = document.createElement("div");
            col.className = "col-sm-6 col-md-4";

            let a = document.createElement("a");

            a.setAttribute("href", "#");
            a.setAttribute("onclick", "getPhotos(" + k + ")");

            let img = document.createElement("img");
            img.setAttribute("src", data[k]);
            img.setAttribute("height", "250");
            img.className = "album_image";

            let box = document.createElement("div");
            box.className = "down-box";

            let inner_div = document.createElement("div");
            inner_div.className = "box-inner";



            let download_a = document.createElement("a");
            download_a.className = "download";
            download_a.setAttribute("href", "#");
            download_a.setAttribute("onclick", "downloadById(" + k + ")");

            let download = document.createElement("i");
            download.className = "fa fa-download";

            let move_a = document.createElement("a");
            move_a.className = "move";
            move_a.setAttribute("href", "https://vipulkerai.xyz/index.php?MoveById="+k);
            

            let move = document.createElement("i");
            move.className = "fa fa-share-square";

            move_a.appendChild(move);

            download_a.appendChild(download);


            let checkbox = document.createElement('input');
            checkbox.className = "selected-checkbox";
            checkbox.setAttribute("type", "checkbox");
            checkbox.setAttribute("onclick", "add(" + k + ")");
            checkbox.setAttribute("name", "albumsId");
            checkbox.setAttribute("value", k);
            checkbox.setAttribute("id", "albumId");

            inner_div.appendChild(download_a);
            inner_div.appendChild(move_a);
            inner_div.appendChild(checkbox);

            box.appendChild(inner_div);

            a.appendChild(img);
            col.appendChild(a);
            col.appendChild(box);
            album.appendChild(col);

        }
    }
}


function refresh() {
    get_albums();
}

function downloadById(albumId) {
    addZipLoader();
    $.ajax({
        type: 'GET',
        url: 'Data_Controller.php',
        data: {
            'downloadById': albumId
        },
        dataType: 'text',
        success: function (data) {
            removeZipLoader();
            show_link(data);
            downloadZip(data);
        },
        error: function (data) {
            
        }

    });
}

function addZipLoader() {
    let zipLoader = document.getElementById("zip-loader");
    zipLoader.style.display = "block";
}

function removeZipLoader() {
    let zipLoader = document.getElementById("zip-loader");
    zipLoader.style.display = "none";
}

function downloadZip(loc) {
    $.ajax({
        type: 'GET',
        url: 'Data_Controller.php',
        data: {
            'downloadZip': loc
        },
        success: function (data) {
            
            window.location = data;

        },
        error: function (data) {
            
        }

    });
}

function show_link(data) {
    if (!data) {
        let link = document.getElementById('link').innerText = "Somethings is Wrong";
    } else {
        let location = data;
        let d = "https://vipulkerai.xyz/download/" + data;

        let a = document.createElement('a');
        a.className = "download-link";
        a.setAttribute("href", "#");
        a.setAttribute("onclick", "downloadZip('" + location + "')");
        a.innerText = d;
        let link = document.getElementById('link');
        if (link.innerText == "Somethings is Wrong") {
            link.innerText = "";
        }
        link.appendChild(a);
    }

}

// function remove_link()
// {
//     let link = document.getElementById('link');

//     if(link.childNodes.length > 0)
//     link.removeChild();
// }


function downloadAll() {
    addZipLoader();
    $.ajax({
        type: 'GET',
        url: 'Data_Controller.php',
        data: {
            'downloadAll': "downloadAll"
        },
        dataType: 'text',
        success: function (data) {
            removeZipLoader();
            show_link(data);
            downloadZip(data);

        },
        error: function (data) {
            
        }

    });
}

function show_Message(d) {
    let message = document.getElementById("mess");

    while (message.firstChild)
        message.removeChild(message.firstChild);

    let a = document.createElement('a');
    a.className = "download-link";
    a.setAttribute("href", "#");
    a.innerText = d;

    message.appendChild(a);
}


var albumbId = [];


function add(id) {
    albumbId.push(id);
}

function selectedDownload() {
    if (albumbId.length == 0) {
        show_Message("You have not selected any album");
    } else {
        addZipLoader();

        $.ajax({
            type: 'GET',
            url: 'Data_Controller.php',
            data: {
                'selectedDownload': albumbId
            },
            dataType: 'text',
            success: function (data) {
                removeZipLoader();
                show_link(data);
                downloadZip(data);
                //albumbId = [];
            },
            error: function (data) {
                
            }

        });
    }

}

function moveSelected() {
    if (albumbId.length == 0) {
        show_Message("You have not selected any album");
    } 
    else 
    {
        show_Message("Your album is moving...");
        var ids = JSON.stringify(albumbId);
        window.location.href = "https://vipulkerai.xyz/index.php?selectedMove=" + ids;
        // $.ajax({
        //     type: 'GET',
        //     url: 'Data_Controller.php',
        //     data: {
        //         'selectedMove': albumbId
        //     },
        //     dataType: 'html',
        //     success: function (data) {

        //         if (data != null)
        //             show_Message("Your album has been Moved");

        //     },
        //     error: function (data) {
        //         
        //     }

        // });
    }
}

function moveById(id) {
    show_Message("Your album is moving...");
    $.ajax({
        type: 'GET',
        url: 'Data_Controller.php',
        data: {
            'MoveById': id
        },
        dataType: 'html',
        success: function (data) {

            if (data != null)
                show_Message("Your album has been Moved");

        },
        error: function (data) {
            
        }

    });
}

function moveAll() {
    show_Message("Your album is moving...");
    $.ajax({
        type: 'GET',
        url: 'Data_Controller.php',
        data: {
            'MoveAll': "MoveAll"
        },
        dataType: 'html',
        success: function (data) {

            if (data != null)
                show_Message("Your album has been Moved");

        },
        error: function (data) {
            
        }

    });
}
