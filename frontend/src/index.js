import React from "react";
import ReactDOM from "react-dom/client";
import { Provider } from "react-redux";
import App from "./App";
import store, { persistor } from "./store";
import { PersistGate } from "redux-persist/integration/react";
import reportWebVitals from "./reportWebVitals";
import "./index.css";
import { BrowserRouter } from "react-router-dom";

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
  // <React.StrictMode>
  <Provider store={store}>
    <PersistGate persistor={persistor}>
    <BrowserRouter>
      <App />
    </BrowserRouter>
    </PersistGate>
  </Provider>
  // </React.StrictMode>
);
reportWebVitals();
