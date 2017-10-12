//INITIALIZING MATERIALIZE ELEMENTS
$(document).ready(function(){
    $('.modal').modal();
    $('.slider').slider();
    /*$('input.autocomplete').autocomplete({
        data: {
            "Apple": null,
            "Microsoft": null,
            "Google": 'https://placehold.it/250x250'
        },
        limit: 20, // The max amount of results that can be shown at once. Default: Infinity.
        onAutocomplete: function(val) {
            // Callback function when value is autcompleted.
        },
        minLength: 1, // The minimum length of the input for the autocomplete to start. Default: 1.
    });*/

});


//ajax functions

function ajaxGET(url,callback){
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            return callback(this.responseText);
        }
    };
    ajax.open( "get", url, true );
    ajax.send();
}

function ajaxPOST(url, formData, callback){
    var ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            return callback(this.responseText);
        }
    };
    ajax.open( "post", url, true );
    var jFormData = new FormData (formData);
    ajax.send(jFormData);
}
//CHECK IF LOGGED IN

window.onload = ajaxGET("api/api-check-if-logged.php",checkIfLoggedIn);
var userType, userId;

function checkIfLoggedIn(sResult){
    var jResult=JSON.parse(sResult);
    console.log(jResult);
    if (jResult.login=="ok"){
        navLogin.style.display="none";
        navUser.style.display="block";
        userType=jResult.userType;
        userId=jResult.id;
        userPage(userId);
    }else{
        navUser.style.display="none";
        navLogin.style.display="block";
    }
}

//NAV

document.addEventListener('click', function(e){
    menuNavigation(e);
    showMoreBandInfo(e);
    showMoreVenueInfo(e);
});

function menuNavigation(e){
    var pageId=e.target.getAttribute('data-page');
    if (pageId){
        var pages = document.querySelectorAll(".page");
        for (var i=0;i<pages.length;i++){
            pages[i].style.display="none";
        }
        var pageClicked = document.getElementById(pageId);
        pageClicked.style.display="grid";

        if(pageId=="pageSignup"){
            checkSignupType.style.display='grid';
            formSignUpBand.style.display="none";
            formSignUpVenue.style.display="none";
        }
        if(pageId=="pageBands"){
            ajaxGET("api/api-get-bands.php", showBands);
        }

        if(pageId=="pageVenues"){
            ajaxGET("api/api-get-venues.php", showVenues);
        }

        if(pageId=="pageUser") {
            if (userType=="venue"){
                google.maps.event.trigger(map, 'resize');
                map.setCenter(marker.position);
            }
        }
        if (pageId=="pageSearch"){
            searchInfo();
        }
    }
}

//SIGNUP

    //check signup type

var btnBandType=document.querySelector('#btnBandType');
var btnVenueType=document.querySelector('#btnVenueType');
var checkSignupType=document.querySelector('#checkSignupType');
var formSignUpBand=document.querySelector('#formSignUpBand');
var formSignUpVenue=document.querySelector('#formSignUpVenue');
var btnSignupBand=document.querySelector('#btnSignupBand');
var btnSignupVenue=document.querySelector('#btnSignupVenue');


btnBandType.addEventListener('click',function(){
    checkSignupType.style.display='none';
    formSignUpBand.style.display="grid";
    formSignUpVenue.style.display="none";
});

btnSignupBand.addEventListener('click', function(){
    console.log('clicked');
    ajaxPOST("api/api-signup-band.php", formSignUpBand, signUp);
});

btnVenueType.addEventListener('click',function(){
    checkSignupType.style.display='none';
    formSignUpVenue.style.display="grid";
});

btnSignupVenue.addEventListener('click', function(){
    ajaxPOST("api/api-signup-venue.php", formSignUpVenue, signUp);
});

function signUp(result){
    console.log(result);
    var signupResult=JSON.parse(result);
    if (signupResult.signup=='error'){
        var errorMessage=document.querySelector('.signupError');
        errorMessage.innerHTML=signupResult.error;
    }else if (signupResult.signup=='success'){
        navLogin.style.display="none";
        navUser.style.display="block";
        pageSignup.style.display="none";
        pageUser.style.display="grid";
        userType=signupResult.userType;
        userId=signupResult.id;
        userPage(userId);
        ajaxGET("api/api-send-email.php", sendEmail);
        ajaxGET("api/api-get-band-info.php?id="+userId,notifyNewBand);
    }

}

//DESKTOP NOTIFICATION
function notifyNewBand(result) {
    var jBand=JSON.parse(result);
    // Let's check if the browser supports notifications
    if (!("Notification" in window)) {
        alert("This browser does not support desktop notification");
    }

    else if (Notification.permission === "granted") {
        notificationSetUp(jBand);
    }

    else if (Notification.permission !== "denied") {
        Notification.requestPermission(function (permission) {
            // If the user accepts, let's create a notification
            if (permission === "granted") {
                notificationSetUp(jBand);
            }
        });
    }
}

function notificationSetUp(jBand){
    var notification = new Notification("A New Band is Here:"+jBand.name, {
        icon: 'data/bandImages/'+jBand.image,
        body: "We thought you might be interested"
    });

}

//SEND EMAILS
function sendEmail(result){
    console.log(result)
}


//LOGIN

var btnLogin=document.querySelector('#btnLogin');
var formLogin=document.querySelector('#formLogin');

btnLogin.addEventListener('click', function(){
    ajaxPOST('api/api-login.php', formLogin, login);
});

function login (sResult){
    var jResult=JSON.parse(sResult);
    if (jResult.login=="ok"){
        userId=jResult.id;
        userPage(userId);
        navLogin.style.display="none";
        navUser.style.display="block";
        pageLogin.style.display="none";
        pageUser.style.display="grid";
        userType=jResult.userType;
    }else{
        console.log("error");
    }
}

//USER PAGE
function userPage(userId){
    console.log(userId);
    var url="api/api-get-user.php?id="+userId;
    ajaxGET(url, showUserInfo);
}
var pageUser=document.querySelector('#pageUser');

function showUserInfo(sUser){
    var jUser=JSON.parse(sUser);
    pageUser.innerHTML="";
    if (jUser.genre){
        bandProfile(jUser);
    }else if(jUser.address){
        venueProfile(jUser);
    }

}

function bandProfile(jUser){
    var bandTemplate = document.querySelector("#bandInfoTemplate").content;
    let cloneUser = bandTemplate.cloneNode(true);
    cloneUser.querySelector('h1').textContent="Welcome, "+jUser.name;
    cloneUser.querySelector('img').src="data/bandImages/"+jUser.image;
    cloneUser.querySelector('.email').textContent="email:"+jUser.email;
    cloneUser.querySelector('.bandDescription').textContent=jUser.description;
    cloneUser.querySelector('.bandPhoneNumber').textContent="phone number:"+jUser.phone;
    cloneUser.querySelector('source').src="data/bandSongs/"+jUser.songFile;
    pageUser.appendChild(cloneUser);

    var btnLogOutBand=document.querySelector("#btnLogOutBand");
    btnLogOutBand.addEventListener('click', function(){
        ajaxGET("api/api-logout.php", goBackToLogin);
    });

    deleteBand(jUser.id);
    editBand(jUser);
}

var mapDiv;

function venueProfile(jUser){
    var venueTemplate = document.querySelector("#venueInfoTemplate").content;
    let cloneUser = venueTemplate.cloneNode(true);
    cloneUser.querySelector('h1').textContent="Your Venue:"+jUser.name;
    cloneUser.querySelector('img').src="data/venueImages/"+jUser.image;
    cloneUser.querySelector('.venueAddress').textContent="Address:"+jUser.address;
    cloneUser.querySelector('.venueDescription').textContent=jUser.description;
    cloneUser.querySelector('.venuePhone').textContent="Phone Number:"+jUser.phone;
    pageUser.appendChild(cloneUser);
    mapDiv=document.querySelector("#map");
    btnSubscribe.checked=jUser.subscribed;
    initMap(mapDiv, jUser);
    var btnLogOutVenue=document.querySelector("#btnLogOutVenue");
    btnLogOutVenue.addEventListener('click', function(){
        ajaxGET("api/api-logout.php", goBackToLogin);
    });

    btnSubscribe.addEventListener('click', function(){
        subscribeToEmail();
    });

    deleteVenue(jUser.id);
    editVenue(jUser);
}

//MAP

var geocoder;
var map, marker;
function initMap(mapDiv, jUser) {
    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': jUser.address}, function(results, status) {
        if (status == 'OK') {
            latlng=results[0].geometry.location;
            var mapOptions = {
                zoom: 15,
                center: results[0].geometry.location
            };
            map = new google.maps.Map(mapDiv, mapOptions);
            marker = new google.maps.Marker({
                map: map,
                position: latlng,
                label: jUser.name
            });
            map.setCenter(latlng);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
    //codeAddress(address);
}

//EDIT USER

function editBand(jUser){
    var btnEditBand=document.querySelector("#btnEditBand");
    btnEditBand.addEventListener('click', function(){
        $('#modalEditBand').modal('open');
        document.getElementsByName("bandNameEdit")[0].value=jUser.name;
        document.getElementsByName("bandGenreEdit")[0].value=jUser.genre;
        document.getElementsByName("bandDescriptionEdit")[0].value=jUser.description;
        document.getElementsByName("bandDescriptionEdit")[0].value=jUser.description;
        document.getElementsByName("bandEmailEdit")[0].value=jUser.email;
        document.getElementsByName("bandPhoneEdit")[0].value=jUser.phone;
        document.getElementsByName("bandPasswordEdit")[0].value=jUser.password;
    });
}

btnSaveEditBand.addEventListener('click', function(){
    ajaxPOST("api/api-edit-band.php", editBandInfo, saveBandChanges)
});

function saveBandChanges(result){
    console.log(result);
    var editResult=JSON.parse(result);
    if (editResult.edit=="success"){
        $('#modalEditBand').modal('close');
        userPage(editResult.id);
    }else{
        var errorMessage=document.querySelector(".editError");
        errorMessage.innerHTML=editResult.error;
    }

}

function editVenue(jUser){
    var btnEditVenue=document.querySelector("#btnEditVenue");
    btnEditVenue.addEventListener('click', function(){
        console.log(jUser);
        $('#modalEditVenue').modal('open');
        document.getElementsByName("venueNameEdit")[0].value=jUser.name;
        document.getElementsByName("venueAddressEdit")[0].value=jUser.address;
        document.getElementsByName("venueDescriptionEdit")[0].value=jUser.description;
        document.getElementsByName("venuePhoneEdit")[0].value=jUser.phone;
        document.getElementsByName("venueEmailEdit")[0].value=jUser.email;
        document.getElementsByName("venuePasswordEdit")[0].value=jUser.password;
    })
}

btnSaveEditVenue.addEventListener('click', function(){
    ajaxPOST("api/api-edit-venue.php", editVenueInfo ,saveVenueChanges);
});

function saveVenueChanges(result){
    console.log(result);
    var editResult=JSON.parse(result);
    if (editResult.edit=="success"){
        $('#modalEditVenue').modal('close');
        userPage(editResult.id);
    }else{
        var errorMessage=document.querySelector(".editErrorVenue");
        errorMessage.innerHTML=editResult.error;
    }
}

//DELETE USER


function deleteBand(userId){
    var btnDeleteBand=document.querySelector('#btnDeleteBand');
    btnDeleteBand.addEventListener('click', function(){
        var url="api/api-delete-band.php";
        ajaxGET(url, deletedResult);
    });
}

function deleteVenue(userId){
    var btnDeleteVenue=document.querySelector('#btnDeleteVenue');
    btnDeleteVenue.addEventListener('click', function(){
        var url="api/api-delete-venue.php?";
        ajaxGET(url, deletedResult);
    });
}


function deletedResult(result){
    console.log(result);
    navUser.style.display="none";
    navLogin.style.display="block";
    goBackToLogin();
}

//LOGOUT

function goBackToLogin(result){
    pageUser.style.display="none";
    pageLogin.style.display="grid";
    navUser.style.display="none";
    navLogin.style.display="block";
}

//PAGE BANDS

function showBands(result){
    console.log(result);
    var jBands=JSON.parse(result);
    bandsContainer.innerHTML="";
    for (var i=0; i<=jBands.length;i++){
        createBandDiv(jBands[i]);
    }

}

function createBandDiv(jBand){
    var bandTemplate = document.querySelector("#bandTemplate").content;
    let cloneBand = bandTemplate.cloneNode(true);
    cloneBand.querySelector('.bandName').textContent=jBand.name;
    cloneBand.querySelector('img').src="data/bandImages/"+jBand.image;
    cloneBand.querySelector('.bandGenre').textContent="Genre:"+jBand.genre;
    cloneBand.querySelector('button').setAttribute('data-id',jBand.id);
    bandsContainer.appendChild(cloneBand);

    /*var btnSeeMore=document.querySelector('.btnSeeMore');
    btnSeeMore.addEventListener('click', function(){
        console.log('clicked');
        /!*$('#modal1').modal('open');*!/
    })*/
}

function showMoreBandInfo(e){
    if (e.target.classList.contains('btnSeeMore')){
        var bandId=e.target.getAttribute('data-id');
        var url="api/api-get-band-info.php?id="+bandId;
        modalContent.innerHTML="";
        ajaxGET(url, createBandModal);
    }
}

function createBandModal(result){
    var jBand=JSON.parse(result);
    console.log(jBand);
    var modalBandTemplate=document.querySelector('#bandModalTemplate').content;
    let cloneModal=modalBandTemplate.cloneNode(true);
    cloneModal.querySelector('h2').textContent=jBand.name;
    cloneModal.querySelector('img').src="data/bandImages/"+jBand.image;
    cloneModal.querySelector('.bandGenre').textContent="Genre:"+jBand.genre;
    cloneModal.querySelector('.email').textContent="Email:"+jBand.email;
    cloneModal.querySelector('.bandDescription').textContent=jBand.description;
    cloneModal.querySelector('.bandPhoneNumber').textContent="Phone Number:"+jBand.phone;
    cloneModal.querySelector('source').src="data/bandSongs/"+jBand.songFile;
    cloneModal.querySelector('.bandBooking').textContent="Booked on: ";
    console.log(jBand.booking);
    for (var i=0;i<jBand.booking.length;i++){
        if (i==0){
            cloneModal.querySelector('.bandBooking').textContent+=jBand.booking[i];
        }else{
            cloneModal.querySelector('.bandBooking').textContent+=', '+jBand.booking[i];
        }
    }
    modalContent.appendChild(cloneModal);

    if (userType=='venue'){
        btnAddBooking.addEventListener('click', function(){
            ajaxPOST("api/api-book-band.php?id="+jBand.id,inputBooking,bookingAdded);
        });
    }else {
        inputBooking.style.display = "none";
    }

    $('#modalInfo').modal('open');

    /*addCalendar();*/
}

function bookingAdded(result){
    console.log(result);
    $('#modalInfo').modal('close');
}

//PAGE VENUES

function showVenues(result){
    var ajVenuesData=JSON.parse(result);
    venuesContainer.innerHTML="";
    initMapAll(ajVenuesData);
    for (var i=0;ajVenuesData.length;i++){
        createVenueDiv(ajVenuesData[i]);
    }
}

function createVenueDiv(jVenue){
    var venueTemplate = document.querySelector("#venueTemplate").content;
    let cloneVenue = venueTemplate.cloneNode(true);
    cloneVenue.querySelector('span').textContent=jVenue.name;
    cloneVenue.querySelector('img').src="data/venueImages/"+jVenue.image;
    cloneVenue.querySelector('.venueAddress').textContent="Address:"+jVenue.address;
    cloneVenue.querySelector('button').setAttribute('data-id',jVenue.id);
    venuesContainer.appendChild(cloneVenue);
}

function showMoreVenueInfo(e){
    if (e.target.classList.contains('btnVenueSeeMore')){
        var venueId=e.target.getAttribute('data-id');
        var url="api/api-get-venue-info.php?id="+venueId;
        /*modalBandContent.innerHTML="";*/
        ajaxGET(url, createVenueModal);
    }
}

function createVenueModal(result){
    var jVenue=JSON.parse(result);
    modalContent.innerHTML="";
    var modalVenueTemplate=document.querySelector('#venueModalTemplate').content;
    let cloneModal=modalVenueTemplate.cloneNode(true);
    cloneModal.querySelector('h2').textContent=jVenue.name;
    cloneModal.querySelector('img').src="data/venueImages/"+jVenue.image;
    cloneModal.querySelector('.venueAddress').textContent="Address:"+jVenue.address;
    cloneModal.querySelector('.venueEmail').textContent="Email:"+jVenue.email;
    cloneModal.querySelector('.venueDescription').textContent=jVenue.description;
    cloneModal.querySelector('.venuePhone').textContent="Phone Number:"+jVenue.phone;

    modalContent.appendChild(cloneModal);

    $('#modalInfo').modal('open');
    var mapDiv=document.querySelector("#mapModal");
    initMap(mapDiv, jVenue);
    google.maps.event.trigger(map, 'resize');
}

//MAP WITH ALL VENUES
var infowindow = new google.maps.InfoWindow();

function initMapAll(ajVenuesData) {
    var copenhagen = {lat: 55.675894, lng: 12.565327};
    var mapAll = new google.maps.Map(document.getElementById('mapAll'), {
        zoom: 12,
        center: copenhagen
    });

    infowindow = new google.maps.InfoWindow();
    
    function geocodeAddress(jVenue) {
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': jVenue.address}, function (results, status) {
            if (status == 'OK') {
                latlng = results[0].geometry.location;
                var markerAll = new google.maps.Marker({
                    map: mapAll,
                    position: latlng
                });
                var venueName=jVenue.name;

                google.maps.event.addListener(markerAll, 'click', function () {
                    infowindow.close(); // Close previously opened infowindow
                    infowindow.setContent("<div id='infowindow'><h5>" + venueName + "</h5></div>");
                    infowindow.open(mapAll, markerAll);
                });

            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
        });
    }

    for (var i = 0; i < ajVenuesData.length; i++) {
        geocodeAddress(ajVenuesData[i]);
    }
}

//SUBSCRIBE TO EMAILS

function subscribeToEmail(){
    /*console.log(btnSubscribe.checked);*/
    ajaxGET("api/api-subscribe-to-email.php", subscribedToEmail);
}

function subscribedToEmail(result){
    console.log(result);
}

//SEARCH FUNCTION

function searchInfo(){
    inputSearch.addEventListener('keyup', function(){
        var searchValue=inputSearch.value;
        ajaxGET("api/api-search.php?search="+searchValue, searchResults);
    })
}

function searchResults(result){
    var ajSearchResults=JSON.parse(result);
    console.log(ajSearchResults);
    searchResultsContainer.innerHTML="";
    for (var i=0;i<ajSearchResults.length;i++){
        if (ajSearchResults[i].genre){
            var jBand=ajSearchResults[i];
            var bandTemplate = document.querySelector("#bandTemplate").content;
            let cloneBand = bandTemplate.cloneNode(true);
            cloneBand.querySelector('.bandName').textContent=jBand.name;
            cloneBand.querySelector('img').src="data/bandImages/"+jBand.image;
            cloneBand.querySelector('.bandGenre').textContent="Genre:"+jBand.genre;
            cloneBand.querySelector('button').setAttribute('data-id',jBand.id);
            searchResultsContainer.appendChild(cloneBand);
        }else{
            var jVenue=ajSearchResults[i];
            var venueTemplate = document.querySelector("#venueTemplate").content;
            let cloneVenue = venueTemplate.cloneNode(true);
            cloneVenue.querySelector('span').textContent=jVenue.name;
            cloneVenue.querySelector('img').src="data/venueImages/"+jVenue.image;
            cloneVenue.querySelector('.venueAddress').textContent="Address:"+jVenue.address;
            cloneVenue.querySelector('button').setAttribute('data-id',jVenue.id);
            searchResultsContainer.appendChild(cloneVenue);
        }
    }

}


