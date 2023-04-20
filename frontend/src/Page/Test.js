import React, { useEffect } from "react";
import useAxios from "../utils/useAxios";

export default function Test() {
  let api = useAxios();
  useEffect(() => {
    getUserInformation();
  }, []);

  const getUserInformation = async () => {
    let res = await api.get("api/profile");
    console.log("🚀 ~ file: test.js:10 ~ getUserInformation ~ res:", res);
  };
  return <div>test</div>;
}
