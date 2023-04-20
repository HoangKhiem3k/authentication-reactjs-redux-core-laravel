import {
  LOGIN_ERROR,
  LOGIN_START,
  LOGIN_SUCCESS,
  LOGOUT_SUCCESS,
} from "../types/authType";
const initialState = {
  currentUser: null,
  // isLoading: false,
  error: false,
};

const authReducer = (state = initialState, action) => {
  switch (action.type) {
    case LOGIN_START:
      return {
        ...state,
        // isLoading: true,
      };
    case LOGIN_SUCCESS:
      return {
        ...state,
        // isLoading: false,
        currentUser: action.payload,
        error: false,
      };
    case LOGIN_ERROR:
      return {
        ...state,
        // isLoading: false,
        error: true,
      };
    case LOGOUT_SUCCESS:
      return {
        ...state,
        currentUser: null,
        // isLoading: false,
        error: false,
      };
    default:
      return state;
  }
};

export default authReducer;
