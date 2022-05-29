import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const userAPI = createApi({
    reducerPath: "userState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getUsers: builder.query({
            query: ({ page, page_count }) => {
                const query = page || page_count ? "/users?" : "/users";

                let params = [];

                if (page) params = [...params, `page=${page}`];
                if (page_count)
                    params = [...params, `page_count=${page_count}`];

                params = params.join("&");

                return `${query}${params}`;
            },
            providesTags: ["ALLUSERS"],
        }),
        getCurrentUser: builder.query({
            query: () => "/user",
        }),
        getUserById: builder.query({
            query: (id) => `/user/${id}`,
        }),
        getUserAuctions: builder.query({
            query: ({ status }) => {
                const query = status
                    ? `/user/auctions?status=${status}`
                    : "/user/auctions";

                return query;
            },
        }),
        getUserByIdAuctions: builder.query({
            query: (id) => `/user/${id}/auctions`,
        }),
        getUserBiddings: builder.query({
            query: () => "/user/biddings",
        }),
        getUserByIdBiddings: builder.query({
            query: (id) => `/user/${id}/biddings`,
        }),
        patchCurrentUser: builder.mutation({
            query: ({
                usr_name,
                usr_lastname,
                usr_email,
                usr_password,
                usr_pass_verify,
                csrf,
            }) => ({
                url: `/user`,
                method: "PATCH",
                body: {
                    usr_name,
                    usr_lastname,
                    usr_email,
                    usr_password,
                    usr_pass_verify,
                    csrf,
                },
            }),
            invalidatesTags: ["ALLUSERS"],
        }),
        patchUserById: builder.mutation({
            query: ({
                usr_id,
                usr_name,
                usr_lastname,
                usr_email,
                usr_password,
                csrf,
            }) => ({
                url: `/user/${usr_id}`,
                method: "PATCH",
                body: {
                    usr_name,
                    usr_lastname,
                    usr_email,
                    usr_password,
                    csrf,
                },
            }),
            invalidatesTags: ["ALLUSERS"],
        }),
        deleteUser: builder.mutation({
            query: (id) => ({
                url: `/user/${id}`,
                method: "DELETE",
            }),
            invalidatesTags: ["ALLUSERS"],
        }),
    }),
});

export default userAPI;
export const {
    useGetUsersQuery,
    useGetCurrentUserQuery,
    useGetUserByIdQuery,
    useGetUserAuctionsQuery,
    useGetUserByIdAuctionsQuery,
    useGetUserBiddingsQuery,
    useGetUserByIdBiddingsQuery,
    usePatchCurrentUserMutation,
    usePatchUserByIdMutation,
    useDeleteUserMutation,
} = userAPI;
