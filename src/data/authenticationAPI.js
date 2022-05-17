import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const authenticationAPI = createApi({
    reducerPath: "authenticationState",
    baseQuery: fetchBaseQuery({
        baseUrl: "https://www.wdev2.be/fs_sander/api",
    }),
    endpoints: (builder) => ({
        postLogin: builder.mutation({
            query: (usr_email, usr_password) => ({
                url: "/login",
                method: "POST",
                body: {
                    usr_email,
                    usr_password,
                },
            }),
        }),
        postRegister: builder.mutation({
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
export const { usePostLoginMutation, usePostRegisterMutation } =
    authenticationAPI;
