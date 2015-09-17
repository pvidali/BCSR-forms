      FB.init({appId: "485430828164963", status: true, cookie: true});

      function postToFeed() {

        // calling the API ...
        var obj = {
          method: 'feed',
//          redirect_uri: 'http://forms.simons-rock.edu/he/201301-1.php',
          link: 'http://forms.simons-rock.edu/he/201301-1.php',
          picture: 'http://forms.simons-rock.edu/he/web_generic_thumb128.png',
          name: 'Bard College at Simon\'s Rock',
          caption: 'Start College after 10th of 11th Grade',
          description: 'No other college in the country does what we do. We\'re a small, selective, supportive, intensive college of the liberal arts and sciences in the middle of the Berkshires, one of the nation\'s cultural and natural treasures.'
        };

        function callback(response) {
          document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
        }

        FB.ui(obj, callback);
      }
    