<template>
  <div class="campaign_team_content">
    <div class="campaign_team">
      <div class="campaign-team-header">
        <div class="select-list">
          <div class="form-group">
            <select class="form-control"
                    id="exampleFormControlSelect1">
              <option class="custom-option"
                      style="height:40px;">Show active team</option>
              <option class="custom-option">Show backup agents</option>
              <option class="custom-option">Show past agents</option>
            </select>
          </div>
        </div>
        <div class="actionBtn">
          <a href="/client/campaign/add-agent">
                        <img src="/images/client/plus.png" alt="plus sign">ADD NEW AGENT
                    </a>
        </div>
      </div>
      <div class="campaign-team-list">
        <div class="campaign-team-row no-decoration">
          <div class="team-member">
            <img src="/images/client/dummy.png" alt="member image">
            <div class="team-member-info">
              <div class="member-name">
                Louis Snyderberg
              </div>
              <div class="job-title">
                Team manager
              </div>
            </div>
          </div>
          <div class="chat-action-btn">
            <img src="/images/client/campaign_activity/send_message.png"
                             alt="chat icon">
                    </div>
            <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#remove-modal">
                        REMOVE
                    </a>
            <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#backup-modal">
                        MAKE BACKUP
                    </a>
          </div>
          <div class="campaign-team-row">
            <div class="team-member">
              <img src="/images/client/dummy.png" alt="member image">
              <div class="team-member-info">
                <div class="member-name">
                  Louis Snyderberg
                </div>
                <div class="job-title">
                  Team manager
                </div>
              </div>
            </div>
            <div class="chat-action-btn">
              <img src="/images/client/campaign_activity/send_message.png"
                             alt="chat icon">
                    </div>
              <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#remove-modal">
                        REMOVE
                    </a>
              <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#backup-modal">
                        MAKE BACKUP
                    </a>
            </div>
            <div class="campaign-team-row">
              <div class="team-member">
                <img src="/images/client/dummy.png" alt="member image">
                <div class="team-member-info">
                  <div class="member-name">
                    Louis Snyderberg
                  </div>
                  <div class="job-title">
                    Team manager
                  </div>
                </div>
              </div>
              <div class="chat-action-btn">
                <img src="/images/client/campaign_activity/send_message.png"
                             alt="chat icon">
                    </div>
                <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#remove-modal">
                        REMOVE
                    </a>
                <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#backup-modal">
                        MAKE BACKUP
                    </a>
              </div>
              <div class="campaign-team-row">
                <div class="team-member">
                  <img src="/images/client/dummy.png" alt="member image">
                  <div class="team-member-info">
                    <div class="member-name">
                      Louis Snyderberg
                    </div>
                    <div class="job-title">
                      Team manager
                    </div>
                  </div>
                </div>
                <div class="chat-action-btn">
                  <img src="/images/client/campaign_activity/send_message.png"
                             alt="chat icon">
                    </div>
                  <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#remove-modal">
                        REMOVE
                    </a>
                  <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#backup-modal">
                        MAKE BACKUP
                    </a>
                </div>
                <div class="campaign-team-row">
                  <div class="team-member">
                    <img src="/images/client/dummy.png" alt="member image">
                    <div class="team-member-info">
                      <div class="member-name">
                        Louis Snyderberg
                      </div>
                      <div class="job-title">
                        Team manager
                      </div>
                    </div>
                  </div>
                  <div class="chat-action-btn">
                    <img src="/images/client/campaign_activity/send_message.png"
                             alt="chat icon">
                    </div>
                    <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#remove-modal">
                        REMOVE
                    </a>
                    <a class="change-status-btn" href="javascript:void(0)" data-toggle="modal" data-target="#backup-modal">
                        MAKE BACKUP
                    </a>
                  </div>
                </div>
              </div>
              <!-- Modal -->
              <div class="modal fade"
                   id="remove-modal"
                   tabindex="-1"
                   role="dialog"
                   aria-labelledby="remove-modal"
                   aria-hidden="true">
                <div class="modal-dialog"
                     role="document">
                  <div class="modal-content border-0"
                       style="margin-top: 30%;">
                    <div class="modal-body campaign-team-modal">
                      <div class="modal-question">
                        Are you sure you want to remove the agent ?
                      </div>
                      <div class="modal-answer">
                        Agent will be in the list of Past agents from this moment.
                      </div>
                      <div class="modal-btn-wrapper">
                        <div class="button-base white-button-a">
                          <a href="javascript:void(0)" data-dismiss="modal">CANCEL</a>
                        </div>
                        <div class="button-base blue-button-a">
                          <a href="javascript:void(0)" data-dismiss="modal">REMOVE THE AGENT</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal fade"
                   id="backup-modal"
                   tabindex="-1"
                   role="dialog"
                   aria-labelledby="backup-modal"
                   aria-hidden="true">
                <div class="modal-dialog"
                     role="document">
                  <div class="modal-content border-0"
                       style="margin-top: 30%;">
                    <div class="modal-body campaign-team-modal">
                      <div class="modal-question">
                        Are you sure you want to make agent back up?
                      </div>
                      <div class="modal-answer">
                        Agent will be in the list of back up agents from this moment.
                      </div>
                      <div class="modal-btn-wrapper">
                        <div class="button-base white-button-a">
                          <a href="javascript:void(0)" data-dismiss="modal">CANCEL</a>
                        </div>
                        <div class="button-base blue-button-a">
                          <a href="javascript:void(0)" data-dismiss="modal">MAKE AGENT BACK UP</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
</template>
<script>
export default {
  mounted() {}
}
</script>
