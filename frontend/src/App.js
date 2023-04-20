import { Routes, Route } from "react-router-dom";
import "./App.css";
import LoginPage from "./Page/LoginPage/LoginPage";
import AdminPage from "./Page/AdminPage/AdminPage";
import PrivateRoute from "./utils/PrivateRoute";
import Test from "./Page/Test";

function App() {
  return (
    <div className="App">
      <Routes>
        <Route exact path="/admin" element={<PrivateRoute />}>
          <Route exact path="/admin" element={<AdminPage />} />
        </Route>
        <Route path="/login" element={<LoginPage />} />
        <Route path="/" element={<LoginPage />} />
        <Route path="/test" element={<Test />} />
      </Routes>
    </div>
  );
}

export default App;
