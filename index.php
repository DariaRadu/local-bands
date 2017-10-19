<?php
session_start();


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Local Bands</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>

    <!--NAVIGATION-->
    <nav>
        <ul>
            <li data-page="pageHome">Home</li>
            <li data-page="pageBands">Bands</li>
            <li data-page="pageVenues">Venues</li>
            <li id="navLogin" data-page="pageLogin">Log In</li>
            <li id="navUser" data-page="pageUser">User</li>
            <li data-page="pageSearch">Search</li>
        </ul>
    </nav>

    <!--PAGE HOME-->
    <div id="pageHome" style="display:grid" class="page">
        <div class="slider">
            <ul class="slides">
                <li>
                    <img src="https://images.pexels.com/photos/78521/rock-concert-smoke-light-78521.jpeg?w=1260&h=750&auto=compress&cs=tinysrgb"> <!-- random image -->
                    <div class="caption right-align">
                        <h1>Check out your local bands and book them for your venue!</h1>
                        <button data-page="pageBands" class="btn">See Bands</button>
                    </div>
                </li>
                <li>
                    <img src="https://images.pexels.com/photos/33779/hand-microphone-mic-hold.jpg?w=1260&h=750&auto=compress&cs=tinysrgb"> <!-- random image -->
                    <div class="caption left-align">
                        <h1>Do you have a band? Check out the local venues!</h1>
                        <button data-page="pageVenues" class="btn">See Venues</button>
                    </div>
                </li>
            </ul>
        </div>

    </div>

    <!--PAGE BANDS-->
    <div id="pageBands" class="page">
        <h2>Here are the local bands in Copenhagen</h2>
        <div id="bandsContainer">
        </div>
    </div>

    <!--PAGE VENUES-->
    <div id="pageVenues" class="page">
        <h2>Here are the local venues in Copenhagen</h2>
        <div id="mapAll" style="width: 800px; height: 300px"></div>
        <div id="venuesContainer">
        </div>
    </div>

    <!--PAGE LOG IN-->
    <div id="pageLogin" class="page">
        <h2>Log In</h2>
        <div id="loginBox">
            <form id="formLogin">
                <label>
                    Email:
                    <input type="email" name="loginEmail" placeholder="email">
                </label>
                <label>
                    Password:
                    <input type="password" name="loginPassword" placeholder="password">
                </label>
                <button id="btnLogin" class="btn" type="button">LOG IN</button>
            </form>
            <p data-page="pageSignup"> New to LocalBands? Sign up here</p>
        </div>
    </div>

    <!--PAGE SIGNUP-->
    <div id="pageSignup" class="page">
        <div id="signupBox">
            <div id="checkSignupType">
                <h3>Do you want to register a band or a venue?</h3>
                <button class="btn" id="btnBandType">BAND</button>
                <button class="btn" id="btnVenueType">VENUE</button>
            </div>
            <form id="formSignUpBand">
                <label>
                    Name of Band:
                    <input type="text" name="bandName">
                </label>
                <label>
                    Band Genre:
                    <input type="text" name="bandGenre">
                </label>
                <label>
                    Band Description:
                    <textarea name="bandDescription"></textarea>
                </label>
                <label>
                    Email:
                    <input type="email" name="bandEmail">
                </label>
                <label>
                    Phone Number:
                    <input type="text" name="bandPhone">
                </label>
                <label>
                    Password:
                    <input type="password" name="bandPassword">
                </label>
                <label>
                    Calendar Name:
                    <input id="bandCalendarName" type="text" name="venueCalendarName">
                </label>
                    Band Image:
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Picture</span>
                            <input type="file" name="bandImage">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    Please upload only .png or .jpg images
                    Band Demo Song:
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Song</span>
                            <input type="file" name="bandDemo">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                     </div>
                    Please upload only mp3 files
                <button id="btnSignupBand" class="btn"  type="button">SIGN UP</button>
            </form>

            <form id="formSignUpVenue">
                <label>
                    Name of Venue:
                    <input type="text" name="venueName">
                </label>
                <label>
                    Address:
                    <input type="text" name="venueAddress">
                </label>
                <label>
                    Venue Description:
                    <textarea name="venueDescription"></textarea>
                </label>
                <label>
                    Phone Number:
                    <input type="number" name="venuePhone">
                </label>
                <label>
                    Email:
                    <input type="email" name="venueEmail">
                </label>
                <label>
                    Password:
                    <input type="password" name="venuePassword">
                </label>
                <label>
                    Calendar Name:
                    <input id="venueCalendarName" type="text" name="venueCalendarName">
                </label>
                    Venue Image:
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>Picture</span>
                            <input type="file" name="venueImage">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                    Please upload only .png or .jpg images
                <p class="error signupError"></p>
                <button id="btnSignupVenue" class="btn"  type="button">SIGN UP</button>
            </form>
        </div>
    </div>

<!--PAGE USER-->
    <div id="pageUser" class="page">
    </div>

<!--PAGE SEARCH-->
    <div id="pageSearch" class="page">
        <div class="input-field col s12">
            <i class="material-icons prefix">search</i>
            <input type="text" id="inputSearch" class="autocomplete">
            <label for="autocomplete-input">Search</label>
        </div>

        <div id="searchResultsContainer">
        </div>
    </div>

<!--TEMPLATES-->
    <template id="bandInfoTemplate">
        <article class="bandInfo">
            <header>
                <h1 class="bandHeader">HEADER</h1>
            </header>
            <div class="content">
                <img class="bandImage" src="" alt="band-picture">
                <p class="bandGenre">Genre</p>
                <p class="email">email</p>
                <p class="bandDescription">description</p>
                <p class="bandPhoneNumber">123</p>
                <audio controls>
                    <source src="" type="audio/mp3">
                </audio>
                <button class="btn" id="btnEditBand">Edit</button>
                <button class="btn" id="btnDeleteBand">Delete</button>
                <button class="btn" id="btnLogOutBand">Log Out</button>
            </div>
        </article>
    </template>

    <template id="venueInfoTemplate">
        <article class="venueInfo">
            <header>
                <h1 class="venueHeader">HEADER</h1>
            </header>
            <div class="content">
                <img class="venueImage" src="" alt="venue-picture">
                <p class="venueDescription">description</p>
                <p class="venueAddress">address</p>
                <p class="venuePhone">123</p>
                <div class="switch">
                    Subscribe to see when new bands are added:
                    <label>
                        <input  id="btnSubscribe" type="checkbox">
                        <span class="lever"></span>
                    </label>
                </div>
                <div class="containerElement">
                    <div id="map"></div>
                </div>

                <button class="btn" id="btnEditVenue">Edit</button>
                <button class="btn" id="btnDeleteVenue">Delete</button>
                <button class="btn" id="btnLogOutVenue">Log Out</button>
            </div>
        </article>
    </template>

    <template id="bandTemplate">
        <div class="bandDiv card">
            <div class="card-image">
                <img class="bandSmallImage" src="" alt="band-picture">
                <header class="card-title">
                    <span class="bandName">Band Name</span>
                </header>
            </div>
            <div class="content">
                <p class="bandGenre">Genre</p>
                <button class="btn btnSeeMore">See More</button>
            </div>
        </div>
    </template>

    <template id="venueTemplate">
        <div class="venueDiv card">
            <div class="card-image">
                <img class="venuesSmallImage" src="" alt="venue-picture">
                <header class="card-title">
                    <span class="venueName">Venue Name</span>
                </header>
            </div>
            <div class="content">
                <p class="venueAddress">address</p>
                <button class="btn btnVenueSeeMore">See More</button>
            </div>
        </div>
    </template>

    <template id="bandModalTemplate">
        <header>
            <h2 class="bandName">Band Name</h2>
        </header>
        <div class="content">
            <img class="bandImage" src="" alt="band-picture">
            <p class="bandGenre">Genre</p>
            <p class="email">email</p>
            <p class="bandDescription">description</p>
            <p class="bandPhoneNumber">123</p>
            <div class="bandAudio">
                <p>Check Out The Demo Song</p>
                <audio controls>
                    <source src="" type="audio/mp3">
                </audio>
            </div>

            <p class="bandBooking">Booked</p>
<!--            <div id="calendar"></div>-->
            <form id="inputBooking">
                <p>Book Them:</p>
                <input id="bookingDate" type="date" name="bandBooking">
                <button type="button" class="btn" id="btnAddBooking">Add Booking</button>
            </form>
        </div>
    </template>

    <template id="venueModalTemplate">
        <header>
            <h2 class="venueName">Venue Name</h2>
        </header>
        <div class="content">
            <img class="venueImage" src="" alt="venue-picture">
            <p class="venueDescription">description</p>
            <p class="venueAddress">address</p>
            <div id="mapModal" style="width: 500px; height: 500px"></div>
            <p class="venueEmail">email</p>
            <p class="venuePhone">123</p>
        </div>
    </template>

    <!--MODALS-->
    <div id="modalInfo" class="modal">
        <div id="modalContent" ="modal-content">
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <div id="modalEditBand" class="modal">
        <div id="modalEditBandContent"="modal-content">
            <form id="editBandInfo">
                <label>
                    Name of Band:
                    <input type="text" name="bandNameEdit">
                </label>
                <label>
                    Band Genre:
                    <input type="text" name="bandGenreEdit">
                </label>
                <label>
                    Band Description:
                    <textarea name="bandDescriptionEdit"></textarea>
                </label>
                <label>
                    Email:
                    <input type="email" name="bandEmailEdit">
                </label>
                <label>
                    Phone Number:
                    <input type="text" name="bandPhoneEdit">
                </label>
                <label>
                    Password:
                    <input type="password" name="bandPasswordEdit">
                </label>
                <label>
                    Band Image:
                    <input type="file" name="bandImageEdit">
                    Please upload only .png or .jpg images
                </label>
                <label>
                    Band Demo Song:
                    <input type="file" name="bandDemoEdit">
                    Please upload only mp3 files
                </label>
                <button id="btnSaveEditBand" class="btn"  type="button">SAVE</button>
            </form>

            <p class="error editError"></p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
        </div>
    </div>

    <div id="modalEditVenue" class="modal">
        <div id="modalEditVenueContent"="modal-content">
            <form id="editVenueInfo">
                <label>
                    Name of Venue:
                    <input type="text" name="venueNameEdit">
                </label>
                <label>
                    Address:
                    <input type="text" name="venueAddressEdit">
                </label>
                <label>
                    Venue Description:
                    <textarea name="venueDescriptionEdit"></textarea>
                </label>
                <label>
                    Phone Number:
                    <input type="number" name="venuePhoneEdit">
                </label>
                <label>
                    Email:
                    <input type="email" name="venueEmailEdit">
                </label>
                <label>
                    Password:
                    <input type="password" name="venuePasswordEdit">
                </label>
                <label>
                    Venue Image:
                    <input type="file" name="venueImageEdit">
                    Please upload only .png or .jpg images
                </label>
                <button id="btnSaveEditVenue" class="btn"  type="button">SAVE</button>
            </form>

        <p class="error editErrorVenue"></p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
    </div>
    </div>



    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTdqr1t3qeknH1CiTZJz2q3FCRMrEtnGk">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script src="js/main.js"></script>
    <script async defer src="https://apis.google.com/js/api.js?onload=handleClientLoad()"
            onload="this.onload=function(){};handleClientLoad()"
            onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>
    <!--<script>
        function handleClientLoad() {
            gapi.load('client:auth2', initClient);
        }
    </script>-->
    </body>
</html>