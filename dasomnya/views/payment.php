<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');


body{
background: linear-gradient(to right, rgba(235,224,232,1) 53%,rgba(52, 171, 235,1) 100%);
font-family: 'Roboto', sans-serif;
}

.card{
	border: none;
	max-width: 450px;
	border-radius: 15px;
	margin: 150px 0 150px;
	padding: 35px;
	padding-bottom: 20px!important;
}
.heading{
	color: #C1C1C1;
	font-size: 14px;
	font-weight: 500;
}
img{
	transform: translate(160px,-10px);
}
img:hover{
    cursor: pointer;
}
.text-warning{
	font-size: 12px;
	font-weight: 500;
	color: #edb537!important;
}
#cno{
	transform: translateY(-10px);
}
input{
	border-bottom: 1.5px solid #E8E5D2!important;
	font-weight: bold;
	border-radius: 0;
	border: 0;

}
.form-group input:focus{
	border: 0;
	outline: 0;
}
.col-sm-5{
	padding-left: 90px;
}
.btn{
	background: rgba(52, 171, 235,1);
	border: none;
	border-radius: 30px;
}
.btn:focus{
    box-shadow: none;
} 
</style> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>



<div class="container-fluid">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-12">
			<div class="card mx-auto">
				<p class="heading">DETALLES DEL PAGO</p>
					<form class="card-details ">
						<div class="form-group mb-0">
								<p class="text-warning mb-0">Número de tarjeta</p> 
                          		<input type="text" name="card-num" placeholder="1234 5678 9012 3456" size="17" id="cno" minlength="19" maxlength="19" pattern="[0-9]+">
								<img class="visa" src="https://img.icons8.com/color/48/000000/visa.png" width="64px" height="60px" />
                        </div>

                        <div class="form-group">
                            <p class="text-warning mb-0">Propietario</p> <input type="text" name="name" placeholder="Nombre completo" size="17">
                        </div>
                        <div class="form-group pt-2">
                        	<div class="row d-flex">
                        		<div class="col-sm-4">
                        			<p class="text-warning mb-0">Vencimiento</p>
                        			<input type="text" name="exp" placeholder="MM/AAAA" size="7" id="exp" minlength="7" maxlength="7">
                        		</div>
                        		<div class="col-sm-3">
                        			<p class="text-warning mb-0">Cvv</p>
                        			<input type="password" name="cvv" placeholder="&#9679;&#9679;&#9679;" size="1" minlength="3" maxlength="3">
                        		</div>
                        		<div class="col-sm-5 pt-0">
                        			<button type="button" class="btn btn-primary">Pagar</button>
                        		</div>
                        	</div>
                        </div>		
					</form>
			</div>
		</div>
	</div>
</div>


<script>
$(document).ready(function(){
    $('.visa').click(function(){
        $(this).attr('src','https://img.icons8.com/color/48/000000/mastercard.png');
		$(this).attr('class','hola');
  });
});

$(document).ready(function(){
    $('.hola').click(function(){
        $(this).attr('src','https://img.icons8.com/color/48/000000/visa.png');
		$(this).attr('class','visa');
  });
});
</script>