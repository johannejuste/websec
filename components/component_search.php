<script>
  document.addEventListener('mouseup', function(e) {
    var container = document.getElementById('search_results');
    console.log(container)
    if (!container.contains(e.target)) {
      container.style.display = 'none';
    }
  });


  // People prof. exp. use this approach
  var search_timer // used to stop the search_timer
  function search() {

    if (search_timer) {
      clearTimeout(search_timer)
    }
    if (event.target.value.length >= 2) {
      search_timer = setTimeout(async function() {

        let conn = await fetch('/search', {
          method: "POST",
          body: new FormData(document.querySelector("#search-form"))
        })
        if (!conn.ok) {
          alert('uppps....')
        }
        console.log(conn, "tisser")
        let users = await conn.json()
        console.log(users)
        console.log("tisser")
        // populate the results
        document.querySelector("#search_results").innerHTML = ""
        users.forEach(user => {
          let user_div = `
          <div class="search_result">
            <a href="/users/${user.user_uuid}">${user.user_name} ${user.user_last_name}</a>
          </div>`
          document.querySelector("#search_results").insertAdjacentHTML('beforeend', user_div)
        })

        show_results()
      }, 500)
    } else {
      hide_results()
    }
  }

  function show_results() {
    document.querySelector("#search_results").style.display = "grid"
    // display search_results div
    // populate/render the individual results
  }

  function hide_results() {
    // hide search_results div
    document.querySelector("#search_results").style.display = "none"
  }
</script>