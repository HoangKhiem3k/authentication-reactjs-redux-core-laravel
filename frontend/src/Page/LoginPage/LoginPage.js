import React, { useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import "./LoginPage.css";
import { useNavigate } from "react-router-dom";
import { loginAction } from "../../store/actions/authActions";
function LoginPage() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const dispatch = useDispatch();
  const navigate = useNavigate();

  const handleEmailChange = (event) => {
    setEmail(event.target.value);
  };

  const handlePasswordChange = (event) => {
    setPassword(event.target.value);
  };

  const handleSubmit = (event) => {
    event.preventDefault();
    // handle login logic here
    const loginData = {
      email,
      password,
    };
    dispatch(loginAction(loginData, navigate));
  };

  return (
    <div className="login-container">
      <form onSubmit={handleSubmit}>
        <label htmlFor="email">Email:</label>
        <input
          type="email"
          id="email"
          name="email"
          value={email}
          onChange={handleEmailChange}
        />

        <label htmlFor="password">Password:</label>
        <input
          type="password"
          id="password"
          name="password"
          value={password}
          onChange={handlePasswordChange}
        />

        <button type="submit">Login</button>
      </form>
    </div>
  );
}

export default LoginPage;
