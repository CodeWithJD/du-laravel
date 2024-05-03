// link copy function
function copyText(btn) {
    var copyInput = document.getElementById("copyInput");
    copyInput.select();
    document.execCommand("copy");
    btn.innerText = "Copied";
    btn.classList.add("btn-success");
    btn.classList.remove("btn-primary");
    setTimeout(function() {
      btn.innerText = "Copy";
      btn.classList.add("btn-primary");
      btn.classList.remove("btn-success");
    }, 2000); // Change button text back to "Copy" after 2 second
  }

  // Counter

  document.addEventListener("DOMContentLoaded", function() {
    counter();
    });


  function counter() {
    var counter = document.querySelectorAll(".counter-value");
    var speed = 250; // The lower the slower
    counter &&
        Array.from(counter).forEach(function(counter_value) {
            function updateCount() {
                var target = +counter_value.getAttribute("data-target");
                var count = +counter_value.innerText;
                var inc = target / speed;
                if (inc < 1) {
                    inc = 1;
                }
                // Check if target is reached
                if (count < target) {
                    // Add inc to count and output in counter_value
                    counter_value.innerText = (count + inc).toFixed(0);
                    // Call function every ms
                    setTimeout(updateCount, 1);
                } else {
                    counter_value.innerText = numberWithCommas(target);
                }
                numberWithCommas(counter_value.innerText);
            }
            updateCount();
        });

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    }
