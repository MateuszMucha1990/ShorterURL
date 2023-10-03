const form = document.querySelector(".wrapper form"),
    fullURL = form.querySelector("input"),
    shortenBtn = form.querySelector("button"),
    blurEffect = document.querySelector(".blur-effects"),
    popupBpx = document.querySelector(".popup-box"),
    form2 = popupBpx.querySelector("form"),
    shortenURL = popupBpx.querySelector("input"),
    saveBtn = popupBpx.querySelector("button"),
    copyBtn = popupBpx.querySelector(".la-copy");


form.onsubmit = (e) => {
    e.preventDefault();
}
shortenBtn.onclick = () => {
    //AJAX
    let xhr = new XMLHttpRequest();   //creating xhr object
    xhr.open("POST", "php/url-controll.php", true);
    xhr.onload = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {  //if ajax request status is ok/succes
            let data = xhr.response;
            if (data.length <= 5) {
                blurEffect.style.display = "block";
                popupBpx.classList.add("show");

                let domain = "http://url.localhost/?";  //dzieki temu ../?u bedziemy mogli przekierowac na org url
                shortenURL.value = domain + data;
                copyBtn.onclick = () => {
                    shortenURL.select();
                    document.execCommand("copy");
                }

                form2.onsubmit = (e) => {
                    e.preventDefault();
                }
                //SAVE btn
                saveBtn.onclick = () => {
                    let xhr2 = new XMLHttpRequest();   //creating xhr2 object
                    xhr2.open("POST", "php/save-url.php", true);
                    xhr2.onload = () => {
                        if (xhr2.readyState == 4 && xhr2.status == 200) {
                          let data = xhr2.response;
                           if(data == "success"){
                            location.reload();
                           }else{
                            alert(data);
                           } 
                        }
                    }
                    //send two data/value from ajax to php  // save-url.php
                    let short_url = shortenURL.value;
                    let hidden_url = data;
                    xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr2.send("shorten_url="+short_url+"&hidden_url="+hidden_url);
                }
            } else {
                alert(data);
            }
        }
    }

    //send from data to php file
    let formData = new FormData(form); //creating new FormData object
    xhr.send(formData);            //sending form value to php
}