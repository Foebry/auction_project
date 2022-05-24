import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const authenticationAPI = createApi({
    reducerPath: "authenticationState",
    baseQuery: fetchBaseQuery({
        baseUrl: "https://www.wdev2.be/fs_sander/api",
        credentials: "include",
    }),
    endpoints: (builder) => ({
        postLogin: builder.mutation({
            query: ({ usr_email, usr_password }, csrf, formkey) => ({
                url: "/login",
                method: "POST",
                body: {
                    usr_email,
                    usr_password,
                    csrf,
                    formkey,
                },
            }),
        }),
        postRegister: builder.mutation({
            query: (
                { usr_name, usr_lastname, usr_email, usr_password },
                csrf,
                formkey
            ) => ({
                url: "/register",
                method: "POST",
                body: {
                    usr_name,
                    usr_lastname,
                    usr_email,
                    usr_password,
                    csrf,
                    formkey,
                },
            }),
        }),
    }),
});

export default authenticationAPI;
export const { usePostLoginMutation, usePostRegisterMutation } =
    authenticationAPI;
