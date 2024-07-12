import React,{useEffect,useState} from 'react'

function Register() {

	const [email,setEmail]=useState('');
	const [password,setPassword]=useState('');

	const register=()=>{

	}

  return (
    <div>
			<label>Register</label>
			<input type="email" value={email} onChange={(e)=>setEmail(e.target.value)}/>
			<br/>
			<label>Password</label>
			<input type="password" value={password} onChange={(e)=> setPassword(e.target.value)}/>
			<br/>
			<button onClick={register}/>
		</div>
  )
}

export default Register