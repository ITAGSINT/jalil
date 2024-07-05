





/////////////////////////
function show() {
  document.getElementById("more").style.display = "block";
   
}
     function openFilter() {
  document.getElementById("myFilter").style.width = "100%";
   document.getElementById("mySort").style.width = "0";

}

/* Set the width of the side navigation to 0 */
function closeFilter() {
  document.getElementById("myFilter").style.width = "0";
  
}
        function openSort() {
  document.getElementById("mySort").style.width = "100%";
  document.getElementById("myFilter").style.width = "0";
}

/* Set the width of the side navigation to 0 */
function closeSort() {
  document.getElementById("mySort").style.width = "0";
}
 
 $(document).mouseup(function (e) {
            var container1 = $(".filter");
            var container = $(".stay");
            if(!container.is(e.target) && 
            container1.has(e.target).length === 0) {
                container1.width('0');
            }
        });
         $(document).mouseup(function (e) {
            var container1 = $(".filter_r");
            var container = $(".stay");
            if(!container.is(e.target) && 
            container1.has(e.target).length === 0) {
                container1.width('0');
            }
        });
$("#p_Filter_id").click(function(){
            
            $("#p_Filter").slideToggle();
            $(this).find($(".fa")).toggleClass('fa-angle-right').toggleClass('fa-angle-down');
          });

  var rangeOne = document.querySelector('input[name="rangeOne"]'),
		rangeTwo = document.querySelector('input[name="rangeTwo"]'),
		outputOne = document.querySelector('.outputOne'),
		outputTwo = document.querySelector('.outputTwo'),
		inclRange = document.querySelector('.incl-range'),
		updateView = function () {
			if (this.getAttribute('name') === 'rangeOne') {
				outputOne.innerHTML = this.value+'AED';
				outputOne.style.left = this.value / this.getAttribute('max') * 100 + '%';
			} else {
				outputTwo.style.left = this.value / this.getAttribute('max') * 100 + '%';
				outputTwo.innerHTML = this.value+'AED';
			}
			if (parseInt(rangeOne.value) > parseInt(rangeTwo.value)) {
				inclRange.style.width = (rangeOne.value - rangeTwo.value) / this.getAttribute('max') * 100 + '%';
				inclRange.style.left = rangeTwo.value / this.getAttribute('max') * 100 + '%';
			} else {
				inclRange.style.width = (rangeTwo.value - rangeOne.value) / this.getAttribute('max') * 100 + '%';
				inclRange.style.left = rangeOne.value / this.getAttribute('max') * 100 + '%';
			}
		};

	document.addEventListener('DOMContentLoaded', function () {
		updateView.call(rangeOne);
		updateView.call(rangeTwo);
		$('input[type="range"]').on('mouseup', function() {
			this.blur();
		}).on('mousedown input', function () {
			updateView.call(this);
		});
	});

	
	
	
	
	
	