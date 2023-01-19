<div style="margin: auto">
  <img src="{{asset('uploads/Chaguch.png')}}" style="width: 200px; display: flex; justify-content: center; margin: auto">
  <br>

  <h4  style="margin: auto" > Вас приветствует социальная сеть Vatan.</h4>

<p >Здравствуйте {{$details['email']}}, </p>
<p >Благодарим Вас за регистрацию.</p>
  <p>  Ваш код подтверждения  {{$details['verification_at']}} </p>
</div>