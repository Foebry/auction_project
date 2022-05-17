import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/dist/query";

const authenticationAPI = createApi({
    reducerPath: "authenticationState",
    baseQuery: fetchBaseQuery({
        baseUrl: "https://www.wdev2.be/fs_sander/api",
    }),
    endpoints: (builder) => ({
        postLogin: builder.query({
            query: (usr_email, usr_password) => ({
                url: "/login",
                method: "POST",
                body: {
                    usr_email,
                    usr_password,
                },
            }),
        }),
        postRegister: builder.query({
            query: (usr_name, usr_lastname, usr_email, usr_password) => ({
                url: "/register",
                method: "POST",
                body: {
                    usr_name,
                    usr_lastname,
                    usr_email,
                    usr_password,
                },
            }),
        }),
    }),
});

export default authenticationAPI;
export const { getPostLoginMutation, getPostRegisterMutation } =
    authenticationAPI;
