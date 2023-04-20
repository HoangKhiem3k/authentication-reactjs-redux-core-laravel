import { Route, Navigate, Outlet } from "react-router-dom";

const PrivateRoute = () => {
  let user = true;
  return user ? <Outlet /> : <Navigate to="/login" />;
};
export default PrivateRoute;
